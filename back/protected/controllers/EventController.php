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
    private $OrganizerModel;
    private $SettingsModel;
    private $UserModel;

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

        /* @var $OrganizerModel OrganizerModel */
        $this->OrganizerModel = new OrganizerModel();

        /* @var $SettingsModel SettingsModel */
        $this->SettingsModel = new SettingsModel();
        
        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();
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
        $country = trim($_POST['country']);
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
            $this->message['error'][] = "Please enter event title.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        if (!$primary_cate)
            $this->message['error'][] = "Please select a primary category.";
        if ($this->validator->is_empty_string($location))
            $this->message['error'][] = "Please enter the location.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Please enter the address.";
        if (count($start_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date starts incorrect.";
        if (count($end_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date ends incorrect.";
        if ($this->validator->is_empty_string($description))
            $this->message['error'][] = "Please enter Event Detail.";

        //$this->validate_tickets();

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";

        if (strtotime($start_time) - strtotime($end_time) >= 0) {
            $this->message['error'][] = "The ending time of your event must be later than the start time.";
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
                $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $address);
        }
        else
            $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $address);

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

        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));



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
            $this->message['error'][] = "Please enter a ticket name.";
        if ($this->validator->is_empty_string(trim($ticket_quantity)))
            $this->message['error'][] = "Please enter the quantity of tickets available for this ticket type";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_quantity)) || trim($ticket_quantity) < 1)
            $this->message['error'][] = "The quantity of tickets must be larger than 0";
        if (array_search($ticket_status, array_flip(Helper::ticket_status())) === false)
            $this->message['error'][] = "Status of tickets does not correct.";
        if (count($ticket_start_date) != 3 || !$this->validator->is_valid_date($ticket_start_date[0], $ticket_start_date[1], $ticket_start_date[2]))
            $this->message['error'][] = "Date starts incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_hour)) || trim($ticket_start_hour) < 0 || trim($ticket_start_hour) > 23)
            $this->message['error'][] = "Hour starts incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_minute)) || trim($ticket_start_minute) < 0 || trim($ticket_start_minute) > 59)
            $this->message['error'][] = "Minute starts incorrect.";
        if (count($ticket_end_date) != 3 || !$this->validator->is_valid_date($ticket_end_date[0], $ticket_end_date[1], $ticket_end_date[2]))
            $this->message['error'][] = "Date ends incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_hour)) || trim($ticket_end_hour) < 0 || trim($ticket_end_hour) > 23)
            $this->message['error'][] = "Hour starts incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_minute)) || trim($ticket_end_minute) < 0 || trim($ticket_end_minute) > 59)
            $this->message['error'][] = "Minute starts incorrect.";
        if ($this->validator->is_empty_string($ticket_min))
            $this->message['error'][] = "Please enter Minimum tickets per order.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_min)) || trim($ticket_min) < 1)
            $this->message['error'][] = "Minimum tickets per order must be larger than 0.";
        if (!$this->validator->is_empty_string($ticket_max) && (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_max)) || trim($ticket_max) < 1))
            $this->message['error'][] = "Maximum tickets per order must be larger than 0.";

        if ($ticket_type == "paid") {
            if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_fee)) || trim($ticket_fee) < 1)
                $this->message['error'][] = "Price of ticeket must be larger than 0.";
            if ($ticket_service_fee != 1 && $ticket_service_fee != 0)
                $this->message['error'][] = "Service fee does not correct.";
        }

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }
        $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";

        if (strtotime($sale_start) - strtotime($sale_end) >= 0) {
            $this->message['error'][] = "The ending time must be later than the start time.";
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
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->message['error'][] = "Ticket type added successfull.";
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
            $this->message['error'][] = "Please enter a ticket name.";
        if ($this->validator->is_empty_string(trim($ticket_quantity)))
            $this->message['error'][] = "Please enter the quantity of tickets available for this ticket type";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_quantity)) || trim($ticket_quantity) < 1)
            $this->message['error'][] = "The quantity of tickets must be larger than 0";
        if (array_search($ticket_status, array_flip(Helper::ticket_status())) === false)
            $this->message['error'][] = "Status of tickets does not correct.";
        if (count($ticket_start_date) != 3 || !$this->validator->is_valid_date($ticket_start_date[0], $ticket_start_date[1], $ticket_start_date[2]))
            $this->message['error'][] = "Date starts incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_hour)) || trim($ticket_start_hour) < 0 || trim($ticket_start_hour) > 23)
            $this->message['error'][] = "Hour starts incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_start_minute)) || trim($ticket_start_minute) < 0 || trim($ticket_start_minute) > 59)
            $this->message['error'][] = "Minute starts incorrect.";
        if (count($ticket_end_date) != 3 || !$this->validator->is_valid_date($ticket_end_date[0], $ticket_end_date[1], $ticket_end_date[2]))
            $this->message['error'][] = "Date ends incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_hour)) || trim($ticket_end_hour) < 0 || trim($ticket_end_hour) > 23)
            $this->message['error'][] = "Hour starts incorrect.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_end_minute)) || trim($ticket_end_minute) < 0 || trim($ticket_end_minute) > 59)
            $this->message['error'][] = "Minute starts incorrect.";
        if ($this->validator->is_empty_string($ticket_min))
            $this->message['error'][] = "Please enter Minimum tickets per order.";
        if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_min)) || trim($ticket_min) < 1)
            $this->message['error'][] = "Minimum tickets per order must be larger than 0.";
        if (!$this->validator->is_empty_string($ticket_max) && (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_max)) || trim($ticket_max) < 0))
            $this->message['error'][] = "Minimum tickets per order must be numbers.";

        if ($ticket['type'] == "paid") {
            if (!$this->validator->is_valid(Yii::app()->getParams()->itemAt('regx_number'), trim($ticket_fee)) || trim($ticket_fee) < 1)
                $this->message['error'][] = "Price of ticeket must be larger than 0.";
            if ($ticket_service_fee != 1 && $ticket_service_fee != 0)
                $this->message['error'][] = "Service fee does not correct.";
        }

        $sold_tickets = $this->TicketModel->counts(array('deleted' => 0, 'ticket_type_id' => $id, 'check_date_expired' => 1));

        if ($ticket_quantity < $sold_tickets)
            $this->message['error'][] = "Ticket number must be greater than or equal to the number of tickets sold. You are sold $sold_tickets tickets.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";

        if (strtotime($sale_start) - strtotime($sale_end) >= 0) {
            $this->message['error'][] = "The ending time must be later than the start time.";
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
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $ticket, 'New data' => $_POST));
        $this->message['error'][] = "Update ticket <strong>$ticket_name</strong> successful.";
        echo json_encode(array('message' => $this->message, 'type' => 'edit'));
    }

    public function actionSearch_location($s = "") {
        if ($this->validator->is_empty_string($s))
            return null;

        $locations = $this->LocationModel->gets(array('deleted' => 0, 's' => $s));

        $tmp = array();
        foreach ($locations as $v)
            $tmp[] = array('title' => $v['title'], 'label' => $v['title'] . " - $v[address] - $v[city_title] ($v[country])", 'value' => $v['id'], 'address' => $v['address'], 'country' => $v['country_id'], 'city' => $v['city_title']);
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
        $country = trim($_POST['country']);
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
            $this->message['error'][] = "Please enter a ticket name.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        if (!$primary_cate)
            $this->message['error'][] = "Please select a primary category.";
        if ($this->validator->is_empty_string($location))
            $this->message['error'][] = "Please enter the location.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Please enter the address.";
        if (count($start_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date starts incorrect.";
        if (count($end_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date ends incorrect.";
        if ($this->validator->is_empty_string($description))
            $this->message['error'][] = "Please enter description.";

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";

        if (strtotime($start_time) - strtotime($end_time) >= 0) {
            $this->message['error'][] = "The ending time must be later than the start time.";
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
                $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $city, $address);
        }
        else
            $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $city, $address);

        //echo $location_id;die;

        $this->LocationModel->update(array('country_id' => $country, 'city_title' => $city, 'id' => $location_id));

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

        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $event, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/event/edit/id/$event[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $category = $this->EventModel->get($id);
        if (!$category)
            return;

        $this->EventModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Delete', 'Data' => array('id' => $id)));
    }

    public function actionDelete_ticket_type($id = 0) {
        $this->CheckPermission();
        $ticket_type = $this->TicketTypeModel->get($id);
        if (!$ticket_type)
            return;

        $cannot_delete = $this->TicketModel->counts(array('deleted' => 0, 'ticket_type_id' => $ticket_type['id'], 'check_date_expired' => 1));

        if ($cannot_delete) {
            $this->message['error'][] = "You cannot delete this ticket because it's ordered. Please contact the administrator of eTicket to refer this problem.";
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $this->TicketTypeModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Deleted', 'Data' => array('id' => $id)));
        $this->message['error'][] = "You delete ticket <strong>$ticket_type[title]</strong>.";
        echo json_encode(array('message' => $this->message));
    }

    public function actionSeo($id) {
        $this->CheckPermission();
        $event = $this->EventModel->get($id);
        if (!$event)
            $this->load_404();
        if ($_POST)
            $this->do_seo($event);
        $this->viewData['event'] = $event;
        $this->viewData['metas'] = $this->EventModel->get_metas($event['id']);
        $this->viewData['type'] = "seo";
        $this->viewData['message'] = $this->message;
        $this->render('seo', $this->viewData);
    }

    private function do_seo($event) {

        $title = trim($_POST['title']);
        $keyword = trim($_POST['keyword']);
        $description = trim($_POST['description']);

        $this->EventModel->update_metas('title', $title, $event['id']);
        $this->EventModel->update_metas('keyword', $keyword, $event['id']);
        $this->EventModel->update_metas('description', $description, $event['id']);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'event_id' => $event['id'], 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/event/seo/id/$event[id]?s=1");
    }

    public function actionPending($p = 1) {
        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $args = array('s' => $s, 'deleted' => 0, 'disabled' => 1);



        $events = $this->EventModel->gets($args, $p, $ppp);
        $total = $this->EventModel->counts($args);

        $this->viewData['events'] = $events;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, HelperUrl::baseUrl() . "product/pending/p/", $total, $p) : "";

        $this->render('pending', $this->viewData);
    }

    public function actionApproved($id, $user) {
        $this->CheckPermission();

        $event = $this->EventModel->get($id);
        if (!$event)
            return;
        $user_email = $user;

        $link_event = HelperUrl::hostInfo() . "event/details/s/" . $event['slug'];

        $note = "Your event was approved . Please visit follow link : <br/>" . $link_event;

        @HelperApp::email($user_email, 'Event was approved', $note);

        $this->EventModel->update(array('deleted' => 0, 'disabled' => 0, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Delete', 'Data' => array('id' => $id)));
    }

    public function actionDestroy() {
        $this->CheckPermission();

        $event_id = isset($_POST['id']) ? $_POST['id'] : "";
        $note = $_POST['note'];
        $user_email = $_POST['email'];


        if ($note == '') {
            $note = "Disabled";
        }
        @HelperApp::email($user_email, 'Event was deleted', $note);


        $this->EventModel->update(array('deleted' => 1, 'reason' => $note, 'id' => $event_id));
        $this->message['success'] = true;
        $this->message['event_id'] = $event_id;
        $this->message['note'] = $note;
        $this->message['email'] = $user_email;

        echo json_encode($this->message);
        die;
    }

    public function actionGallery($id) {
        $event = $this->EventModel->get($id);
        $gallerys = $this->EventModel->gets_gallery($event['id']);




        if ($_FILES)
            $this->upload_gallery($event);
        $this->viewData['type'] = 'gallery';
        $this->viewData['event'] = $event;
        $this->viewData['gallerys'] = $gallerys;
        $this->viewData['message'] = $this->message;

        $this->render('gallery', $this->viewData);
    }

    private function upload_gallery($event) {
        for ($i = 1; $i <= 5; $i++) {
            $image[$i] = $_FILES['file_' . $i];
            if (!$this->validator->is_empty_string($image[$i]['name'])) {
                $resize = HelperApp::resize_images($image[$i], HelperApp::get_gallery_sizes());
                $img = $resize['img'];
                $thumbnail = $resize['thumbnail'];
                $this->EventModel->add_gallery($event['id'], $img, $thumbnail);
            }
        }
        $this->redirect(Yii::app()->request->baseUrl . "/event/gallery/id/$event[id]?s=1");
    }

    public function actionDelete_gallery($id) {

        $this->EventModel->delete_gallery($id);
    }

    public function actionInfo($id) {
        HelperGlobal::require_login();

        $event = $this->EventModel->get($id);

        if (!$event)
            $this->load_404();


        $ticket_types = $this->TicketTypeModel->gets(array('event_id' => $event['id']), 1, 300);
        $client = $this->OrganizerModel->get_by_user($event['user_id']);
        
        if ($_POST){
            $this->do_update_info($event,$client);
        }
        
        $usd = $this->SettingsModel->get_usd();
        $ttd = $this->SettingsModel->get_ttd();
        //print_r($ticket_types);die;
        $this->viewData['usd'] = $usd;
        $this->viewData['ttd'] = $ttd;
        $this->viewData['event'] = $event;
        $this->viewData['ticket_types'] = $ticket_types;
        $this->viewData['client'] = $client;
        $this->viewData['message'] = $this->message;
        $this->render('info', $this->viewData);
    }

    private function do_update_info($event,$client){
        $this->EventModel->update(array('is_paid'=>1,'id'=>$event['id']));
        
        $url = HelperUrl::hostInfo();
        
        $message = '
                <div style="font-family:\'bebasneue\',Tahoma,Verdana;font-size:16px;color:#000;margin:0 auto;padding:0;width: 500px">
                    <div>
                        <div><img width="180px" src="'.$url.'front/img/logo.png"/></div>
                    </div>
                    <div style="font-family: \'bebasneue\',Tahoma,Verdana;font-size:24px; background-color: #414143;color:#fff;padding: 5px 10px;text-transform: capitalize;margin-bottom: 10px">
                        Payment Event
                    </div>
                    <div class="content" style="font-family: \'bebasneue\',Tahoma,Verdana;padding:10px">
                        <p style="margin-bottom: 10px;margin-top:0">Congatulations,</p>
                        <p style="margin-bottom: 10px;margin-top:0">Your Event has been successfully paid from admin.</p>
                        <p style="margin-bottom: 0px;margin-top:0">
                            Regards,<br/>
                            The 360 Island Events Team.    
                        </p>
                        <a href="#"><img src="'.$url.'front/img/email_fb.png"/></a>
                        <a href="#"><img src="'.$url.'front/img/email_tw.png"/></a>
                    </div>
                </div>
        ';
        // $message;die;
        @HelperApp::email($client['email'], '360islandevents.com - Payment for event '.$event['title'], $message);
        
        $this->redirect(HelperUrl::baseUrl().'event/info/id/'.$event['id'].'?s=1');
        die;
    }
    
    private function do_paypal($event,$ticket_types,$client) {

        $usd = $this->SettingsModel->get_usd();
        $ttd = $this->SettingsModel->get_ttd();
        
        
        $total_amount = 0;
        foreach ($ticket_types as $t) {
            if ($t['service_fee']) {
                $total = round($t['total_ticket'] * $t['price'] * 1.1, 2);
            } else {
                $total = round($t['total_ticket'] * $t['price'], 2);
            }
            $total_amount += $total;
        }
        
        $user = $this->UserModel->get($event['user_id']);

        $payment_to = Yii::app()->params['business'];
        $currency = 'USD';
        $amount = $total_amount*($usd['option_value']/$ttd['option_value']);
        $tracking_id = $this->TrackingModel->add('paypal', $payment_to, $currency, $event['user_id'], $amount, 'send_money');

        $return_url = HelperUrl::baseUrl(true) . "event/info/id/$event[id]";
        $cancel_url = HelperUrl::baseUrl(true) . "event/info/id/$event[id]";
        $notify_url = HelperUrl::baseUrl(true) . "event/process_paypal/";

        $queryStr = "?business=" . urlencode($payment_to);

        $data = array('item_name' => "Purchase ticket of event : " . $event['title'] . ".",
            'amount' => round($amount, 2),
            'first_name' => $user['firstname'],
            'last_name' => $user['lastname'],
            'payer_email' => 'info@eticket.com',
            'cmd' => '_xclick',
            'no_note' => '1',
            'lc' => 'US',
            'currency_code' => $currency,
            'item_number' => $event['id'],
            'return' => $return_url,
            'cancel_return' => $cancel_url,
            'custom' => $tracking_id,
            'quantity' => 1,
            'notify_url' => $notify_url
            );
        foreach ($data as $key => $value) {
            $value = urlencode(stripslashes($value));
            $queryStr .= "&$key=$value";
        }

        $this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr' . $queryStr);
        //$this->redirect('https://www.paypal.com/cgi-bin/webscr' . $queryStr);
        die;
    }

    public function actionProcess_paypal() {
        if (!$_POST)
            return;
        //$this->PaypalModel->test(serialize($_POST));
        $txn_id = isset($_POST['txn_id']) ? $_POST['txn_id'] : null;
        if (!$txn_id)
            return;

        $data['item_number'] = $_POST['item_number'];
        $data['package_id'] = $_POST['item_number'];
        $data['payment_status'] = $_POST['payment_status'];
        $data['payment_amount'] = $_POST['mc_gross'];
        $data['paypal_fee'] = $_POST['mc_fee'];
        $data['txn_id'] = $_POST['txn_id'];
        $data['custom'] = $_POST['custom'];
        $data['currency'] = $_POST['mc_currency'];
        $data['firstname'] = $_POST['first_name'];
        $data['lastname'] = $_POST['last_name'];
        $data['payer_email'] = $_POST['payer_email'];
        $payment_to = Yii::app()->params['business'];


        //if ($_POST['test_ipn'] == 1)
        //exit();
        // check that receiver_email is your Primary PayPal email and status must be completed

        if ($_POST['business'] != $payment_to || $data['payment_status'] != "Completed")
            exit();
        //check if has txn_id 
        if ($this->TrackingModel->get_by_txn_id($data['txn_id']))
            exit();

        $tracking = $this->TrackingModel->get($data['custom']);

        // check that payment_amount/payment_currency are correct
        if (!$tracking || $tracking['payment_type'] != "paypal" || $tracking['amount'] != $data['payment_amount'] || $tracking['completed'] == 1 || strtoupper($data['currency']) != $tracking['currency'])
            exit();

        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $header = '';
        // post back to PayPal system to validate

        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        //comment this line if not sandbox
        $header .= "Host: www.sandbox.paypal.com \r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        //$fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);


        if (!$fp)
            exit();

        fputs($fp, $header . $req);
        while (!feof($fp)) {

            $res = fgets($fp, 1024);

            if (strcmp($res, "INVALID") == 0) {
                //log for manual investigation
                fclose($fp);
                exit();
            }
            //process payment if all verfified
            //$this->PaypalModel->test($res);
            if (strcmp($res, "VERIFIED") == 0) {
                $paypal_id = $this->PaypalModel->add($data['txn_id'], $tracking['id'], $data['paypal_fee'], serialize($_POST));
                $this->TrackingModel->update(array('ref_id' => $paypal_id, 'txn_id' => $data['txn_id'], 'completed' => 1, 'id' => $tracking['id']));

                //update status is_paid
                
                $this->EventModel->update(array('is_paid'=>1,'id'=>$data['item_number']));
                
                //$this->email_register_event($order, $order_details);
            }
        }
        fclose($fp);
        exit();
    }

}