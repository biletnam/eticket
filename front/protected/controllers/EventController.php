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

    /**
     * Declares class-based actions.
     */
    public function actions() {
        
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->render('index', $this->viewData);
    }

    public function actionSearch_location($s = "") {
        if ($this->validator->is_empty_string($s))
            return null;

        $locations = $this->LocationModel->gets(array('deleted' => 0, 's' => $s));

        $tmp = array();
        foreach ($locations as $v)
            $tmp[] = array('title' => $v['title'], 'label' => $v['title'] . " - $v[address] ($v[city])", 'value' => $v['id'], 'address' => $v['address'], 'city' => $v['city_id']);
        echo json_encode($tmp);
    }

    public function actionCreate() {
        HelperGlobal::require_login();
        if ($_POST)
            $this->do_create();

        $this->viewData['message'] = $this->message;
        $this->viewData['categories'] = $this->CategoryModel->gets(array('deleted' => 0, 'type' => 'event'));
        Yii::app()->params['page'] = 'Create Event';
        $this->render('create', $this->viewData);
    }

    private function do_create() {

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
        $show_tickets = isset($_POST['show_tickets']) ? 1 : 0;
        //$is_repeat = isset($_POST['is_repeat']) ? 1 : 0;

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter Event Title.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        if (!$primary_cate)
            $this->message['error'][] = "Please select a primary category.";
        if ($primary_cate == $second_cate)
            $this->message['error'][] = "Primary category and Second category must be different.";
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
            if ($loc['title'] != $location || $loc['city_id'] != $city)
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
            'show_tickets' => $show_tickets));
        //'is_repeat' => $is_repeat));
        //add new event category
        $this->EventModel->add_event_category($event_id, $primary_cate, 1);
        if ($second_cate)
            $this->EventModel->add_event_category($event_id, $second_cate, 0);

        $note = "Your event :" . $title . "was created, please wait admin approve.";

        @HelperApp::email(UserControl::getEmail(), 'Event was created', $note);

        $this->redirect(HelperUrl::baseUrl() . "event/edit/id/$event_id/?s=1&msg= You have created event <strong>$title</strong>");
    }

    public function actionEdit($id = "", $type = "general") {
        HelperGlobal::require_login();
        $event = $this->EventModel->get($id);
        if (!$event || $event['user_id'] != UserControl::getId())
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
        Yii::app()->params['page'] = '';
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
        $show_tickets = isset($_POST['show_tickets']) ? 1 : 0;
        //$is_repeat = isset($_POST['is_repeat']) ? 1 : 0;

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter Event Title.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        if (!$primary_cate)
            $this->message['error'][] = "Please select a primary category.";
        if ($primary_cate == $second_cate)
            $this->message['error'][] = "Primary category and Second category must be different.";
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
            if ($loc['title'] != $location || $loc['city'] != $city)
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
            'show_tickets' => $show_tickets));
        //'is_repeat' => $is_repeat));
        //delete old event category
        $this->EventModel->delete_event_category($event['id']);

        //add new event category
        $this->EventModel->add_event_category($event['id'], $primary_cate, 1);
        if ($second_cate)
            $this->EventModel->add_event_category($event['id'], $second_cate, 0);

        $this->redirect(HelperUrl::baseUrl() . "event/edit/id/$event[id]/?s=1");
    }

    public function actionGallery($s) {
        $event = $this->EventModel->get_by_slug($s);
        $gallerys = $this->EventModel->gets_gallery($event['id']);
        
 
     

        if ($_FILES)
            $this->upload_gallery($event);
           $this->viewData['event'] = $event;
           $this->viewData['gallerys'] = $gallerys;
        
        $this->render('gallery', $this->viewData);
    }

    private function upload_gallery($event) {
        for ($i = 1; $i <= 5; $i++) {
            $image[$i] = $_FILES['file_' . $i];
            if (!$this->validator->is_empty_string($image[$i]['name'])) {
                $resize = HelperApp::resize_images($image[$i], HelperApp::get_gallery_sizes());
                $img = $resize['img'];
                $thumbnail = $resize['thumbnail'];
                $this->EventModel->add_gallery($event['id'], $img,$thumbnail);
            }
        }
        $this->redirect(HelperUrl::baseUrl() . "event/gallery/s/".$event['slug']);
    }
    
    public function actionDelete_gallery($id){
   
        $this->EventModel->delete_gallery($id);
        
    }

    public function actionRemove_thumb($id) {
        HelperGlobal::require_login();
        $event = $this->EventModel->get($id);
        if (!$event || $event['user_id'] != UserControl::getId())
            return;

        if ($event['thumbnail'] == "") {
            echo json_encode($this->message);
            die;
        }

        $thumbnail = unserialize($event['thumbnail']);
        foreach ($thumbnail as $v)
            @unlink(Yii::app()->getParams()->itemAt('upload_dir') . "media/" . $v['folder'] . $v['filename']);
        $this->EventModel->update(array('img' => '', 'thumbnail' => '', 'id' => $id));
        echo json_encode($this->message);
    }

    public function actionAdd_ticket_type() {
        HelperGlobal::require_login();
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

        $this->message['error'][] = "New ticket has been added successfully.";
        echo json_encode(array('id' => $ticket_type_id, 'message' => $this->message, 'type' => 'add'));
    }

    public function actionEdit_ticket_type($id = 0) {

        HelperGlobal::require_login();
        $ticket = $this->TicketTypeModel->get($id);
        if (!$ticket || $ticket['author_id'] != UserControl::getId())
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

        $this->message['error'][] = "Update ticket <strong>$ticket_name</strong> successful.";
        echo json_encode(array('message' => $this->message, 'type' => 'edit'));
    }

    public function actionDelete_ticket_type($id = 0) {
        HelperGlobal::require_login();
        $ticket_type = $this->TicketTypeModel->get($id);
        if (!$ticket_type || $ticket_type['author_id'] != UserControl::getId())
            return;

        $cannot_delete = $this->TicketModel->counts(array('deleted' => 0, 'ticket_type_id' => $ticket_type['id'], 'check_date_expired' => 1));

        if ($cannot_delete) {
            $this->message['error'][] = "You cannot delete this ticket because it's ordered. Please contact the administrator of eTicket to refer this problem.";
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $this->TicketTypeModel->update(array('deleted' => 1, 'id' => $id));

        $this->message['error'][] = "You delete ticket <strong>$ticket_type[title]</strong>.";
        echo json_encode(array('message' => $this->message));
    }

    public function actionInfo($s) {
        HelperGlobal::require_login();

        $event = $this->EventModel->get_by_slug($s);
        if (count($event) == 0)
            $this->load_404();

        $ticket_types = $this->TicketTypeModel->gets_by_event($event['id']);

        Yii::app()->params['page'] = 'Event Detail';

        $this->viewData['ticket_types'] = $ticket_types;
        $this->viewData['event'] = $event;
        $this->render('event', $this->viewData);
    }

    public function actionRegister_to_event($event) {
        HelperGlobal::require_login();

//        if($_POST)
//            $this->do_register();

        $event = $this->EventModel->get_by_slug($event);


        $ticket_types = $this->TicketTypeModel->gets_by_event($event['id']);

        for ($i = 1; $i <= $_POST['count_ticket_type']; $i++) {
            $ticket_types_id = $_POST[$i];
            $number_ticket = $_POST['number_tichket_' . $i];

            foreach ($ticket_types as $k => $t)
                if ($t['id'] == $ticket_types_id)
                    $ticket_types[$k]['number_ticket'] = $number_ticket;
        }




        $this->viewData['ticket_types'] = $ticket_types;
        $this->viewData['event'] = $event;
        Yii::app()->params['page'] = 'Payment Ticket';
        $this->render('payment_ticket', $this->viewData);
    }


    
    public function actionSearch($p = 1) {

        $s = isset($_GET['title']) ? $_GET['title'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $cate = isset($_GET['cate']) ? $_GET['cate'] : "";
        $date = isset($_GET['date']) ? $_GET['date'] : "";
        $city = isset($_GET['city']) ? $_GET['city'] : "";
        //$city = strlen($city) > 2 ? $city : "";
//        $price = isset($_GET['price']) ? $_GET['price'] : "";
//        $cid = isset($_GET['cid']) ? $_GET['cid'] : "";
//        $oid = isset($_GET['oid']) ? $_GET['oid'] : "";
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        if($city == 0){ 
            $args = array('search_title' => $s, 'search_cate' => $cate, 'date' => $date);
        }else{
            $args = array('search_title' => $s, 'search_city' => $city, 'search_cate' => $cate, 'date' => $date);
        }
        $events = $this->EventModel->gets($args, $p, $ppp);
        $total = $this->EventModel->counts($args);

        //print_r($events);die;

        $event_categories = $this->CategoryModel->gets(array('deleted' => 0, 'type' => 'event'));
        $event_city = $this->LocationModel->gets(array('deleted' => 0));

//        if ($s || $city)
//            $this->KeywordModel->add($s, $city, 0, time());

        $this->viewData['events'] = $events;
        $this->viewData['total'] = $total;
        $this->viewData['event_categories'] = $event_categories;
        $this->viewData['event_city'] = $event_city;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/event/search/p/", $total, $p) : "";
        $this->viewData['query_string'] = $this->get_query_string();
        Yii::app()->params['page'] = "Find Events";
        $this->render('search', $this->viewData);
    }

    private function get_query_string() {
        $queryString = Yii::app()->request->queryString;
        $queryString = explode('&', $queryString);
        $params = array();
        foreach ($queryString as $k => $v) {
            $tmp = explode('=', $v);
            if (count($tmp) != 2)
                continue;
            $params[$tmp[0]] = $tmp[1];
        }
        return $params;
    }

    public function actionDo_register() {
        for ($i = 1; $i <= $_POST['count_ticket_type']; $i++) {
            $ticket_types_id = $_POST[$i];
            $number_ticket = $_POST['number_tichket_' . $ticket_types_id];

            for ($j = 1; $j <= $number_ticket; $j++) {
                $args = array('ticket_type_id' => $ticket_types_id, 'user_id' => UserControl::getId(), 'contact_fullname' => UserControl::getFirstname(), 'contact_email' => UserControl::getEmail());
                $this->TicketModel->add_ticket($args);
            }
        }
    }

    public function actionDetails($s) {
        HelperGlobal::require_login();

        $event = $this->EventModel->get_by_slug($s);
        if (count($event) == 0)
            $this->load_404();

        $ticket_types = $this->TicketTypeModel->gets_by_event($event['id']);

        foreach ($ticket_types as $k => $t) {
            $count_tikect_sold = $this->TicketModel->ticket_sold($t['id']);
            $ticket_types[$k]['ticket_available'] = ($t['quantity'] - $count_tikect_sold);
        }



        Yii::app()->params['page'] = 'Event Detail';

        $this->viewData['ticket_types'] = $ticket_types;
        $this->viewData['event'] = $event;
        $this->render('details', $this->viewData);
    }

}