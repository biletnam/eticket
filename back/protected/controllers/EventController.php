<?php

class EventController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $CategoryModel;
    private $EventModel;
    private $LocationModel;
    private $TicketTypeModel;
    private $TicketModel;

    public function init() {

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();

        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();

        /* @var $LocationModel LocationModel */
        $this->LocationModel = new LocationModel();

        /* @var $TicketTypeModel TicketTypeModel */
        $this->TicketTypeModel = new TicketTypeModel();

        /* @var $TicketModel TicketModel */
        $this->TicketModel = new TicketModel();
    }

    public function actions() {
        
    }

    public function actionTest() {
        //echo "dsadsa";
        $start = microtime();
        $category = $this->CategoryModel->get(1);
        print_r($category);
        $end = microtime();
        echo $end - $start;
        die;
    }

    public function actionIndex($p = 1) {

        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        $args = array('s' => $s, 'deleted' => 0);

        $events = $this->EventModel->gets($args, $p, $ppp);
        $total = $this->EventModel->counts($args);

        $this->viewData['events'] = $events;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/event/index/p/", $total, $p) : "";

        $this->render('index', $this->viewData);
    }

    public function actionAdd() {
        $this->load_404();
        $this->CheckPermission();
        if ($_POST)
            $this->do_add();

        $this->viewData['categories'] = $this->CategoryModel->gets(array('deleted' => 0, 'type' => 'event'));
        $this->viewData['message'] = $this->message;
        $this->render('add', $this->viewData);
    }

    private function do_add() {

        $title = trim($_POST['title']);
        $file = $_FILES['file'];
        $primary_cate = $_POST['primary_cate'];
        $second_cate = $_POST['second_cate'];
        $location_id = $_POST['location_id'];
        $location = trim($_POST['location']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $start_date = trim($_POST['start_date']);
        $start_date = explode('-', $start_date);
        $start_hour = trim($_POST['start_hour']);
        $start_minute = trim($_POST['start_minute']);
        $end_date = trim($_POST['end_date']);
        $end_date = explode('-', $end_date);
        $end_hour = trim($_POST['end_hour']);
        $end_minute = trim($_POST['end_minute']);
        $description = trim($_POST['description']);
        $display_start_time = isset($_POST['display_start_time']) ? 1 : 0;
        $display_end_time = isset($_POST['display_end_time']) ? 1 : 0;
        $show_tickets = $_POST['show_tickets'];

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Tiêu đề không được để trống.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "Hình ảnh không đúng định dạng hoặc dung lượng.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Hình ảnh không đúng kích thướt.";
        if (!$primary_cate)
            $this->message['error'][] = "Vui lòng chọn thể loại chính.";
        if ($this->validator->is_empty_string($location))
            $this->message['error'][] = "Địa điểm không được để trống.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Địa chỉ không được để trống.";
        if (count($start_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Ngày bắt đầu không chính xác.";
        if (count($end_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Ngày kết thúc không chính xác.";
        if ($this->validator->is_empty_string($description))
            $this->message['error'][] = "Nội dung không được để trống.";

        //$this->validate_tickets();

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";

        if (strtotime($start_time) - strtotime($end_time) >= 0) {
            $this->message['error'][] = "Ngày bắt đầu phải nhỏ hơn ngày kết thúc.";
            $this->message['success'] = false;
            return false;
        }

        $img = "";
        $thumbnail = "";
        // check if has thumbnail
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_event_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }


        //check if have location then get that location, add new location otherwise
        if ($location_id) {
            $loc = $this->LocationModel->get($location_id);
            if ($loc['title'] != $location)
                $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $city, $address);
        }
        else
            $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $city, $address);

        //add new event
        $event_id = $this->EventModel->add(array('user_id' => UserControl::getId(),
            'title' => $title,
            'slug' => Helper::create_slug($title),
            'location_id' => $location_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'display_start_time' => $display_start_time,
            'display_end_time' => $display_end_time,
            'img' => $img,
            'thumbnail' => $thumbnail,
            'description' => $description,
            'published' => $_POST['published'],
            'show_tickets' => $show_tickets,
            'is_repeat' => $_POST['is_repeat']));

        //add new event category
        $this->EventModel->add_event_category($event_id, $primary_cate, 1);
        if ($second_cate)
            $this->EventModel->add_event_category($event_id, $second_cate, 0);

        //$this->add_ticket_types($event_id);

        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Thêm', 'Dữ liệu' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/event/edit/id/$event_id/?s=1");
    }

    public function actionAdd_ticket_type() {
        $this->CheckPermission();
        $event_id = $_POST['event_id'];
        $event = $this->EventModel->get($event_id);
        if (!$event || $event['author_id'] != UserControl::getId())
            return;

        $ticket_type = $_POST['ticket_type'];
        if (array_search($ticket_type, array_flip(Helper::ticket_types())) === false)
            return;

        $ticket_name = $_POST['ticket_name'];
        $ticket_quantity = $_POST['ticket_quantity'];
        $ticket_fee = isset($_POST['ticket_fee']) ? $_POST['ticket_fee'] : null;
        $ticket_status = $_POST['ticket_status'];
        $ticket_description = $_POST['ticket_description'];
        $ticket_hide_description = isset($_POST['ticket_hide_description']) ? 1 : 0;
        $ticket_start_date = $_POST['ticket_start_date'];
        $ticket_start_hour = $_POST['ticket_start_hour'];
        $ticket_start_minute = $_POST['ticket_start_minute'];
        $ticket_end_date = $_POST['ticket_end_date'];
        $ticket_end_hour = $_POST['ticket_end_hour'];
        $ticket_end_minute = $_POST['ticket_end_minute'];
        $ticket_min = $_POST['ticket_min'];
        $ticket_max = $_POST['ticket_max'];
        $ticket_service_fee = isset($_POST['ticket_service_fee']) ? $_POST['ticket_service_fee'] : null;
        $ticket_start_date = explode('-', $ticket_start_date);
        $ticket_end_date = explode('-', $ticket_end_date);


        if ($this->validator->is_empty_string(trim($ticket_name)))
            $this->message['error'][] = "Tên loại vé không được để trống";
        if ($this->validator->is_empty_string(trim($ticket_quantity)))
            $this->message['error'][] = "Số lượng không được để trống";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_quantity)) || trim($ticket_quantity) < 1)
            $this->message['error'][] = "Số lượng phải là số lớn hơn 0";
        if (array_search($ticket_status, array_flip(Helper::ticket_status())) === false)
            $this->message['error'][] = "Tình trạng vé không chính xác";
        if (count($ticket_start_date) != 3 || !$this->validator->is_valid_date($ticket_start_date[0], $ticket_start_date[1], $ticket_start_date[2]))
            $this->message['error'][] = "Ngày bắt đầu không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_hour)) || trim($ticket_start_hour) < 0 || trim($ticket_start_hour) > 23)
            $this->message['error'][] = "Giờ bắt đầu không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_minute)) || trim($ticket_start_minute) < 0 || trim($ticket_start_minute) > 59)
            $this->message['error'][] = "Phút bắt đầu không chính xác.";
        if (count($ticket_end_date) != 3 || !$this->validator->is_valid_date($ticket_end_date[0], $ticket_end_date[1], $ticket_end_date[2]))
            $this->message['error'][] = "Ngày kết thúc không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_hour)) || trim($ticket_end_hour) < 0 || trim($ticket_end_hour) > 23)
            $this->message['error'][] = "Giờ bắt đầu không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_minute)) || trim($ticket_end_minute) < 0 || trim($ticket_end_minute) > 59)
            $this->message['error'][] = "Phút bắt đầu không chính xác.";
        if ($this->validator->is_empty_string($ticket_min))
            $this->message['error'][] = "Số lượng vé tối thiểu không được để trống";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_min)) || trim($ticket_min) < 1)
            $this->message['error'][] = "Số lượng vé tối thiểu phải là số lớn hơn 0";
        if (!$this->validator->is_empty_string($ticket_max) && (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_max)) || trim($ticket_max) < 1))
            $this->message['error'][] = "Số lượng vé tối đa phải là số lớn hơn 0";

        if ($ticket_type == "paid") {
            if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_fee)) || trim($ticket_fee) < 1)
                $this->message['error'][] = "Giá vé phải là số lớn hơn 0";
            if ($ticket_service_fee != 1 && $ticket_service_fee != 0)
                $this->message['error'][] = "Phí dịch vụ không chính xác";
        }

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }
        $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";

        if (strtotime($sale_start) - strtotime($sale_end) >= 0) {
            $this->message['error'][] = "Thời gian kết thúc phải lớn hơn thời gian bắt đầu";
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $price = 0;
        $tax = 0;
        $service_fee = 0;

        if ($ticket_type == "paid") {
            $price = $ticket_fee;
            $total = (int) $ticket_quantity * $ticket_fee;
            $tax = Yii::app()->getParams()->itemAt('ticket_tax') * $total;
            $service_fee = $ticket_service_fee;
        }
        $ticket_type_id = $this->TicketTypeModel->add(array('event_id' => $event_id, 'type' => $ticket_type,
            'title' => $ticket_name, 'quantity' => $ticket_quantity,
            'price' => $price, 'tax' => $tax,
            'ticket_status' => $ticket_status, 'description' => $ticket_description,
            'hide_description' => $ticket_hide_description, 'sale_start' => $sale_start,
            'sale_end' => $sale_end, 'minimum' => $ticket_min,
            'maximum' => $ticket_max, 'service_fee' => $service_fee
                ));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Thêm', 'Dữ liệu' => $_POST));
        $this->message['error'][] = "Thêm loại vé mới thành công";
        echo json_encode(array('id' => $ticket_type_id, 'message' => $this->message, 'type' => 'add'));
    }

    public function actionEdit_ticket_type($id = 0) {
        $this->CheckPermission();
        $ticket = $this->TicketTypeModel->get($id);
        if (!$ticket)
            return;
        if (array_search($ticket['type'], array_flip(Helper::ticket_types())) === false)
            return;


        $ticket_name = $_POST['ticket_name'];
        $ticket_quantity = $_POST['ticket_quantity'];
        $ticket_fee = isset($_POST['ticket_fee']) ? $_POST['ticket_fee'] : null;
        $ticket_status = $_POST['ticket_status'];
        $ticket_description = $_POST['ticket_description'];
        $ticket_hide_description = isset($_POST['ticket_hide_description']) ? 1 : 0;
        $ticket_start_date = $_POST['ticket_start_date'];
        $ticket_start_hour = $_POST['ticket_start_hour'];
        $ticket_start_minute = $_POST['ticket_start_minute'];
        $ticket_end_date = $_POST['ticket_end_date'];
        $ticket_end_hour = $_POST['ticket_end_hour'];
        $ticket_end_minute = $_POST['ticket_end_minute'];
        $ticket_min = $_POST['ticket_min'];
        $ticket_max = $_POST['ticket_max'];
        $ticket_service_fee = isset($_POST['ticket_service_fee']) ? $_POST['ticket_service_fee'] : null;
        $ticket_start_date = explode('-', $ticket_start_date);
        $ticket_end_date = explode('-', $ticket_end_date);


        if ($this->validator->is_empty_string(trim($ticket_name)))
            $this->message['error'][] = "Tên loại vé không được để trống";
        if ($this->validator->is_empty_string(trim($ticket_quantity)))
            $this->message['error'][] = "Số lượng không được để trống";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_quantity)) || trim($ticket_quantity) < 1)
            $this->message['error'][] = "Số lượng phải là số lớn hơn 0";
        if (array_search($ticket_status, array_flip(Helper::ticket_status())) === false)
            $this->message['error'][] = "Tình trạng vé không chính xác";
        if (count($ticket_start_date) != 3 || !$this->validator->is_valid_date($ticket_start_date[0], $ticket_start_date[1], $ticket_start_date[2]))
            $this->message['error'][] = "Ngày bắt đầu không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_hour)) || trim($ticket_start_hour) < 0 || trim($ticket_start_hour) > 23)
            $this->message['error'][] = "Giờ bắt đầu không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_minute)) || trim($ticket_start_minute) < 0 || trim($ticket_start_minute) > 59)
            $this->message['error'][] = "Phút bắt đầu không chính xác.";
        if (count($ticket_end_date) != 3 || !$this->validator->is_valid_date($ticket_end_date[0], $ticket_end_date[1], $ticket_end_date[2]))
            $this->message['error'][] = "Ngày kết thúc không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_hour)) || trim($ticket_end_hour) < 0 || trim($ticket_end_hour) > 23)
            $this->message['error'][] = "Giờ bắt đầu không chính xác.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_minute)) || trim($ticket_end_minute) < 0 || trim($ticket_end_minute) > 59)
            $this->message['error'][] = "Phút bắt đầu không chính xác.";
        if ($this->validator->is_empty_string($ticket_min))
            $this->message['error'][] = "Số lượng vé tối thiểu không được để trống";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_min)) || trim($ticket_min) < 1)
            $this->message['error'][] = "Số lượng vé tối thiểu phải là số lớn hơn 0";
        if (!$this->validator->is_empty_string($ticket_max) && (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_max)) || trim($ticket_max) < 0))
            $this->message['error'][] = "Số lượng vé tối đa phải là số";

        if ($ticket['type'] == "paid") {
            if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_fee)) || trim($ticket_fee) < 1)
                $this->message['error'][] = "Giá vé phải là số lớn hơn 0";
            if ($ticket_service_fee != 1 && $ticket_service_fee != 0)
                $this->message['error'][] = "Phí dịch vụ không chính xác";
        }

        $sold_tickets = $this->TicketModel->counts(array('deleted' => 0, 'ticket_type_id' => $id, 'check_date_expired' => 1));

        if ($ticket_quantity < $sold_tickets)
            $this->message['error'][] = "Số lượng vé phải lớn hơn hoặc bằng lượng vé bán ra. Bạn đã bán ra $sold_tickets vé.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";

        if (strtotime($sale_start) - strtotime($sale_end) >= 0) {
            $this->message['error'][] = "Thời gian kết thúc phải lớn hơn thời gian bắt đầu";
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $price = 0;
        $tax = 0;
        $service_fee = 0;
        if ($ticket['type'] == "paid") {
            $price = $ticket_fee;
            $total = (int) $ticket_quantity * $ticket_fee;
            $tax = Yii::app()->getParams()->itemAt('ticket_tax') * $total;
            $service_fee = $ticket_service_fee;
        }

        $this->TicketTypeModel->update(array('id' => $ticket['id'],
            'title' => $ticket_name, 'quantity' => $ticket_quantity,
            'price' => $price, 'tax' => $tax,
            'ticket_status' => $ticket_status, 'description' => $ticket_description,
            'hide_description' => $ticket_hide_description, 'sale_start' => $sale_start,
            'sale_end' => $sale_end, 'minimum' => $ticket_min,
            'maximum' => $ticket_max, 'service_fee' => $service_fee,
            'last_modified' => time()
        ));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Sửa', 'Dữ liệu cũ' => $ticket, 'Dữ liệu mới' => $_POST));
        $this->message['error'][] = "Cập nhật loại vé <strong>$ticket_name</strong> thành công";
        echo json_encode(array('message' => $this->message, 'type' => 'edit'));
    }

    public function actionSearch_location($s = "") {
        if ($this->validator->is_empty_string($s))
            return null;

        $locations = $this->LocationModel->gets(array('deleted' => 0, 's' => $s));
        $tmp = array();
        foreach ($locations as $v)
            $tmp[] = array('title' => $v['title'], 'label' => $v['title'] . " - $v[address] ($v[city])", 'value' => $v['id'], 'address' => $v['address'], 'city' => $v['city']);
        echo json_encode($tmp);
    }

    public function actionEdit($id = "", $type = "general") {
        $this->CheckPermission();
        $event = $this->EventModel->get($id);
        if (!$event)
            $this->load_404();

        if ($_POST) {
            if ($type == "general")
                $this->do_edit($event);
        }

        $this->viewData['ticket_types'] = $this->TicketTypeModel->gets(array('deleted' => 0, 'event_id' => $id), 1, 200);
        $this->viewData['categories'] = $this->CategoryModel->gets(array('deleted' => 0, 'type' => 'event'), 1, 200);
        $this->viewData['message'] = $this->message;
        $this->viewData['event'] = $event;
        $this->viewData['type'] = $type;

        $this->render('edit', $this->viewData);
    }

    private function do_edit($event) {
        $title = trim($_POST['title']);
        $file = $_FILES['file'];
        $primary_cate = $_POST['primary_cate'];
        $second_cate = $_POST['second_cate'];
        $location_id = $_POST['location_id'];
        $location = trim($_POST['location']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $start_date = trim($_POST['start_date']);
        $start_date = explode('-', $start_date);
        $start_hour = trim($_POST['start_hour']);
        $start_minute = trim($_POST['start_minute']);
        $end_date = trim($_POST['end_date']);
        $end_date = explode('-', $end_date);
        $end_hour = trim($_POST['end_hour']);
        $end_minute = trim($_POST['end_minute']);
        $description = trim($_POST['description']);
        $display_start_time = isset($_POST['display_start_time']) ? 1 : 0;
        $display_end_time = isset($_POST['display_end_time']) ? 1 : 0;
        $show_tickets = $_POST['show_tickets'];

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Tiêu đề không được để trống.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "Hình ảnh không đúng định dạng hoặc dung lượng.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Hình ảnh không đúng kích thướt.";
        if (!$primary_cate)
            $this->message['error'][] = "Vui lòng chọn thể loại chính.";
        if ($this->validator->is_empty_string($location))
            $this->message['error'][] = "Địa điểm không được để trống.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Địa chỉ không được để trống.";
        if (count($start_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Ngày bắt đầu không chính xác.";
        if (count($end_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Ngày kết thúc không chính xác.";
        if ($this->validator->is_empty_string($description))
            $this->message['error'][] = "Nội dung không được để trống.";

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";

        if (strtotime($start_time) - strtotime($end_time) >= 0) {
            $this->message['error'][] = "Ngày bắt đầu phải nhỏ hơn ngày kết thúc.";
            $this->message['success'] = false;
            return false;
        }

        $img = $event['img'];
        $thumbnail = $event['thumbnail'];

        // check if has thumbnail
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_event_sizes(), $event['img']);
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        //check if have location then get that location, add new location otherwise
        if ($location_id) {
            $loc = $this->LocationModel->get($location_id);
            if ($loc['title'] != $location)
                $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $city, $address);
        }
        else
            $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $city, $address);

        //update event
        $this->EventModel->update(array('id' => $event['id'],
            'title' => $title,
            'location_id' => $location_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'display_start_time' => $display_start_time,
            'display_end_time' => $display_end_time,
            'img' => $img,
            'thumbnail' => $thumbnail,
            'description' => $description,
            'published' => $_POST['published'],
            'show_tickets' => $show_tickets,
            'is_repeat' => $_POST['is_repeat']));

        //delete old event category
        $this->EventModel->delete_event_category($event['id']);

        //add new event category
        $this->EventModel->add_event_category($event['id'], $primary_cate, 1);
        if ($second_cate)
            $this->EventModel->add_event_category($event['id'], $second_cate, 0);

        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Sửa', 'Dữ liệu cũ' => $event, 'Dữ liệu mới' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/event/edit/id/$event[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $category = $this->CategoryModel->get($id);
        if (!$category)
            return;

        $this->CategoryModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Xóa', 'Dữ liệu' => array('id' => $id)));
    }

    public function actionDelete_ticket_type($id = 0) {
        $this->CheckPermission();
        $ticket_type = $this->TicketTypeModel->get($id);
        if (!$ticket_type)
            return;

        $cannot_delete = $this->TicketModel->counts(array('deleted' => 0, 'ticket_type_id' => $ticket_type['id'], 'check_date_expired' => 1));

        if ($cannot_delete) {
            $this->message['error'][] = "Bạn không thể xóa loại vé này vì đã có người đặt vé. Vui lòng liên hệ với Ban quản trị của VeSuKien.vn để xem xét vấn đề này.";
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $this->TicketTypeModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Xóa', 'Dữ liệu' => array('id' => $id)));
        $this->message['error'][] = "Bạn đã xóa loại vé <strong>$ticket_type[title]</strong>.";
        echo json_encode(array('message' => $this->message));
    }

    public function actionSeo($id) {
        $this->CheckPermission();
        $event = $this->EventModel->get($id);
        if (!$event)
            $this->load_404();
        if($_POST)
            $this->do_seo($event);
        $this->viewData['event'] = $event;
        $this->viewData['metas'] = $this->EventModel->get_metas($event['id']);
        $this->viewData['type'] = "seo";
        $this->viewData['message'] = $this->message;
        $this->render('seo',$this->viewData);
    }
    
    private function do_seo($event){
        
        $title = trim($_POST['title']);
        $keyword = trim($_POST['keyword']);
        $description = trim($_POST['description']);
        
        $this->EventModel->update_metas('title', $title, $event['id']);
        $this->EventModel->update_metas('keyword', $keyword, $event['id']);
        $this->EventModel->update_metas('description', $description, $event['id']);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Cập nhật', 'event_id'=>$event['id'],'Dữ liệu mới' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl."/event/seo/id/$event[id]?s=1");
    }

}