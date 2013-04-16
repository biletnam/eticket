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
    private $OrderModel;
    private $CountryModel;
    private $TrackingModel;
    private $PaypalModel;
    private $SettingsModel;
    private $UserModel;
    private $EmailModel;

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

        /* @var $OrderModel OrderModel */
        $this->OrderModel = new OrderModel();

        /* @var $CountryModel CountryModel */
        $this->CountryModel = new CountryModel();

        /* @var $TrackingModel TrackingModel */
        $this->TrackingModel = new TrackingModel();

        /* @var $PaypalModel PaypalModel */
        $this->PaypalModel = new PaypalModel();

        /* @var $SettingsModel SettingsModel */
        $this->SettingsModel = new SettingsModel();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();

        /* @var $EmailModel EmailModel */
        $this->EmailModel = new EmailModel();
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
            $tmp[] = array('title' => $v['title'], 'label' => $v['title'] . " - $v[address] - $v[city_title] ($v[country])", 'value' => $v['id'], 'address' => $v['address'], 'country' => $v['country_id'], 'city' => $v['city_title']);
        echo json_encode($tmp);
    }

    public function actionCreate() {
        if (!UserControl::LoggedIn()) {
            $this->redirect(HelperUrl::baseUrl() . 'user/signup');
            die;
        }
        if (UserControl::getRole() == 'waiting' && UserControl::LoggedIn()) {
            Yii::app()->params['page'] = 'Create Event';
            $this->viewData['message'] = 'Your client account is pending. Please <a href="' . HelperUrl::baseUrl() . 'page/contact_us">contact us</a> for more info.';
            $this->render('access', $this->viewData);
            die;
        }
        if (UserControl::getRole() == 'customer' && UserControl::LoggedIn()) {
            Yii::app()->params['page'] = 'Create Event';
            //$this->viewData['message'] = 'You are not authorized to access this page.';
            $this->viewData['message'] = 'To create an event you must first be registered and approved by our team.<br/>
                                If you would like to upgrade your account please contact us at <a href="mailto:sales@sachacosmetics.com">sales@sachacosmetics.com</a>.<br/><br/>
                                In the mean time you can still browse events and purchase tickets by <a href="' . HelperUrl::baseUrl() . 'event/search">clicking here';
            $this->render('access', $this->viewData);
            die;
        }



        //HelperGlobal::require_login();
//        if(UserControl::getRole()!='client' && UserControl::LoggedIn())
//            $this->load_404();

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
        $address_2 = trim($_POST['address_2']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);
        $start_date = trim($_POST['start_date']);
        $start_date = explode('-', $start_date);
        $start_hour = trim($_POST['start_hour']);
        $start_minute = trim($_POST['start_minute']);
        $start_am_pm = trim($_POST['start_am_pm']);
        $end_date = trim($_POST['end_date']);
        $end_date = explode('-', $end_date);
        $end_hour = trim($_POST['end_hour']);
        $end_minute = trim($_POST['end_minute']);
        $end_am_pm = trim($_POST['end_am_pm']);
        $description = trim($_POST['description']);
        $display_start_time = 1;
        $display_end_time = 1;
        $show_tickets = isset($_POST['show_tickets']) ? 1 : 0;

        $facebook = $_POST['facebook'];
        $link = $_POST['link'];
        //$is_repeat = isset($_POST['is_repeat']) ? 1 : 0;

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter Event Title.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(1920, 1080, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        if (!$primary_cate)
            $this->message['error'][] = "Please select Category.";
//        if ($primary_cate == $second_cate)
//            $this->message['error'][] = "Primary category and Second category must be different.";
//        if ($this->validator->is_empty_string($location))
//            $this->message['error'][] = "Please enter the Location.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Please enter the Address.";
        if ($this->validator->is_empty_string($city))
            $this->message['error'][] = "Please enter the City.";
        if (count($start_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date starts incorrect.";
        if (count($end_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date ends incorrect.";
        if ($this->validator->is_empty_string($description))
            $this->message['error'][] = "Please enter Event Description.";

        //$this->validate_tickets();

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        if ($start_am_pm == 'am') {
            $start_hour = $start_hour == "12" ? "00" : $start_hour;
            $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        } else {
            $start_hour += 12;
            $start_hour = $start_hour == 24 ? 12 : $start_hour;
            $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        }
        if ($end_am_pm == 'am') {
            $end_hour = $end_hour == "12" ? "00" : $end_hour;
            $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";
        } else {
            $end_hour += 12;
            $end_hour = $end_hour == 24 ? 12 : $end_hour;
            $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";
        }

        if (strtotime($start_time) - strtotime($end_time) >= 0) {
            $this->message['error'][] = "The ending time of your event must be later than the start time.";
            $this->message['success'] = false;
            return false;
        }

        $img = "";
        $thumbnail = "";
        // check if has thumbnail
        if (!$this->validator->is_empty_string($_POST['file_temp'])) {
            $filesize = filesize($_POST['file_temp']);
            $image_info = getimagesize($_POST['file_temp']);
            $filetype = $image_info['mime'];
            $tmp_file = array('tmp_name' => $_POST['file_temp'], 'name' => $_POST['name_temp'], 'error' => 0, 'type' => $filetype, 'size' => $filesize);
            $resize = HelperApp::resize_images($tmp_file, HelperApp::get_event_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }


        //check if have location then get that location, add new location otherwise
        if ($location_id) {
            $loc = $this->LocationModel->get($location_id);
            if ($loc['title'] != $location || $loc['country_id'] != $country)
                $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $city, $address, $address_2);
        }
        else
            $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $city, $address, $address_2);


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
            'facebook' => $facebook,
            'link' => $link,
            'disabled' => 0));
        //'is_repeat' => $is_repeat));
        //add new event category
        $this->EventModel->add_event_category($event_id, $primary_cate, 1);
        if ($second_cate)
            $this->EventModel->add_event_category($event_id, $second_cate, 0);

        $email_template = $this->EmailModel->get_by_slug('event-registration');

        @HelperApp::email(UserControl::getEmail(), $email_template['title'], $email_template['content']);

        $temp_file = $_POST['file_temp'];
        if ($temp_file != '')
            @unlink($temp_file);

//        $this->redirect(HelperUrl::baseUrl() . "event/edit/id/$event_id/?s=1&msg= You have created event <strong>$title</strong>");
        $this->redirect(HelperUrl::baseUrl() . "event/edit/id/$event_id/type/ticket");
    }

    public function actionEdit($id = "", $type = "general") {
        HelperGlobal::require_login();


        $event = $this->EventModel->get($id);

        if (!$event || $event['user_id'] != UserControl::getId())
            $this->load_404();
        if (strtotime($event['end_time']) <= time())
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
        $country = trim($_POST['country']);
        $start_date = trim($_POST['start_date']);
        $start_date = explode('-', $start_date);
        $start_hour = trim($_POST['start_hour']);
        $start_minute = trim($_POST['start_minute']);
        $start_am_pm = trim($_POST['start_am_pm']);
        $end_date = trim($_POST['end_date']);
        $end_date = explode('-', $end_date);
        $end_hour = trim($_POST['end_hour']);
        $end_minute = trim($_POST['end_minute']);
        $end_am_pm = trim($_POST['end_am_pm']);
        $description = trim($_POST['description']);
        $display_start_time = 1;
        $display_end_time = 1;
        $show_tickets = isset($_POST['show_tickets']) ? 1 : 0;
        //$is_repeat = isset($_POST['is_repeat']) ? 1 : 0;

        $facebook = $_POST['facebook'];
        $link = $_POST['link'];

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter Event Title.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(1920, 1080, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        if (!$primary_cate)
            $this->message['error'][] = "Please select a Category.";
//        if ($primary_cate == $second_cate)
//            $this->message['error'][] = "Primary category and Second category must be different.";
//        if ($this->validator->is_empty_string($location))
//            $this->message['error'][] = "Please enter the location.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Please enter the address.";
        if (count($start_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date starts incorrect.";
        if ($this->validator->is_empty_string($city))
            $this->message['error'][] = "Please enter the city.";
        if (count($end_date) != 3 || !$this->validator->is_valid_date($start_date[0], $start_date[1], $start_date[2]))
            $this->message['error'][] = "Date ends incorrect.";
        if ($this->validator->is_empty_string($description))
            $this->message['error'][] = "Please enter Event Description.";

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        if ($start_am_pm == 'am') {
            $start_hour = $start_hour == "12" ? "00" : $start_hour;
            $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        } else {
            $start_hour += 12;
            $start_hour = $start_hour == 24 ? 12 : $start_hour;
            $start_time = "$start_date[2]-$start_date[1]-$start_date[0] $start_hour:$start_minute:00";
        }
        if ($end_am_pm == 'am') {
            $end_hour = $end_hour == "12" ? "00" : $end_hour;
            $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";
        } else {
            $end_hour += 12;
            $end_hour = $end_hour == 24 ? 12 : $end_hour;
            $end_time = "$end_date[2]-$end_date[1]-$end_date[0] $end_hour:$end_minute:00";
        }

        if (strtotime($start_time) - strtotime($end_time) >= 0) {
            $this->message['error'][] = "The ending time of your event must be later than the start time.";
            $this->message['success'] = false;
            return false;
        }

        $img = $event['img'];
        $thumbnail = $event['thumbnail'];

        // check if has thumbnail
        if (!$this->validator->is_empty_string($_POST['file_temp'])) {
            $filesize = filesize($_POST['file_temp']);
            $image_info = getimagesize($_POST['file_temp']);
            $filetype = $image_info['mime'];
            $tmp_file = array('tmp_name' => $_POST['file_temp'], 'name' => $_POST['name_temp'], 'error' => 0, 'type' => $filetype, 'size' => $filesize);
            $resize = HelperApp::resize_images($tmp_file, HelperApp::get_event_sizes(), $event['img']);
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        //check if have location then get that location, add new location otherwise
        if ($location_id) {
            $loc = $this->LocationModel->get($location_id);
            if ($loc['title'] != $location || $loc['country_id'] != $country)
                $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $city, $address);
        }
        else
            $location_id = $this->LocationModel->add($location, Helper::create_slug($location), $country, $city, $address);

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
            'facebook' => $facebook,
            'link' => $link,
            'published' => $_POST['published'],
            'show_tickets' => $show_tickets));

        //'is_repeat' => $is_repeat));
        //delete old event category
        $this->EventModel->delete_event_category($event['id']);

        //add new event category
        $this->EventModel->add_event_category($event['id'], $primary_cate, 1);
        if ($second_cate)
            $this->EventModel->add_event_category($event['id'], $second_cate, 0);

        //remove file upload temp
        $temp_file = $_POST['file_temp'];
        if ($temp_file != '')
            @unlink($temp_file);

        $this->redirect(HelperUrl::baseUrl() . "event/edit/id/$event[id]/?s=1");
    }

    public function actionGallery($id) {
        $event = $this->EventModel->get($id);
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
                $this->EventModel->add_gallery($event['id'], $img, $thumbnail);
            }
        }
        $this->redirect(HelperUrl::baseUrl() . "event/gallery/id/" . $event['id']);
    }

    public function actionDelete_gallery($id) {

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
        $start_am_pm = trim($_POST['start_am_pm']);
        $ticket_end_date = $_POST['ticket_end_date'];
        $ticket_end_hour = $_POST['ticket_end_hour'];
        $ticket_end_minute = $_POST['ticket_end_minute'];
        $end_am_pm = trim($_POST['end_am_pm']);
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

        if ($start_am_pm == 'am') {
            $ticket_start_hour = $ticket_start_hour == "12" ? "00" : $ticket_start_hour;
            $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        } else {
            $ticket_start_hour += 12;
            $ticket_start_hour = $ticket_start_hour == 24 ? 12 : $ticket_start_hour;
            $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        }
        if ($end_am_pm == 'am') {
            $ticket_end_hour = $ticket_end_hour == "12" ? "00" : $ticket_end_hour;
            $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";
        } else {
            $ticket_end_hour += 12;
            $ticket_end_hour = $ticket_end_hour == 24 ? 12 : $ticket_end_hour;
            $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";
        }


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

        $this->message['error'][] = 'A new ticket has been added. <br/> To view your event click <a href="'.HelperUrl::baseUrl().'event/info/s/'.$event['slug'].'">here</a>. <br/> To add a new ticket option click "Add Ticket" below.';
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
        $start_am_pm = trim($_POST['start_am_pm']);
        $ticket_end_date = $_POST['ticket_end_date'];
        $ticket_end_hour = $_POST['ticket_end_hour'];
        $ticket_end_minute = $_POST['ticket_end_minute'];
        $end_am_pm = trim($_POST['end_am_pm']);
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

        if ($start_am_pm == 'am') {
            $ticket_start_hour = $ticket_start_hour == "12" ? "00" : $ticket_start_hour;
            $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        } else {
            $ticket_start_hour += 12;
            $ticket_start_hour = $ticket_start_hour == 24 ? 12 : $ticket_start_hour;
            $sale_start = "$ticket_start_date[2]-$ticket_start_date[1]-$ticket_start_date[0] $ticket_start_hour:$ticket_start_minute:00";
        }
        if ($end_am_pm == 'am') {
            $ticket_end_hour = $ticket_end_hour == "12" ? "00" : $ticket_end_hour;
            $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";
        } else {
            $ticket_end_hour += 12;
            $ticket_end_hour = $ticket_end_hour == 24 ? 12 : $ticket_end_hour;
            $sale_end = "$ticket_end_date[2]-$ticket_end_date[1]-$ticket_end_date[0] $ticket_end_hour:$ticket_end_minute:00";
        }

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
            $this->message['error'][] = "You cannot delete this ticket because it's ordered. Please contact the administrator of 360 Island Events to refer this problem.";
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }

        $this->TicketTypeModel->update(array('deleted' => 1, 'id' => $id));

        $this->message['error'][] = "You delete ticket <strong>$ticket_type[title]</strong>.";
        echo json_encode(array('message' => $this->message));
    }

    public function actionInfo($s) {

        $event = $this->EventModel->get_by_slug($s);
        if (!$event)
            $this->load_404();

        if ($_POST)
            $this->do_add_event_token($event);

        $ticket_types = $this->TicketTypeModel->gets(array('deleted' => 0, 'event_id' => $event['id']), 1, 100);

        foreach ($ticket_types as $k => $v) {
            $tmp_quantity = $this->TicketTypeModel->get_tmp_quantity($v['id']);
            $total_paid_ticket = (int) $v['total_ticket'] == 0 ? 0 : $v['total_ticket'];
            $remaining = $v['quantity'] - $tmp_quantity - $total_paid_ticket;
            $v['remaining'] = $remaining;
            $v['total_ticket'] = $total_paid_ticket;
            $ticket_types[$k] = $v;
        }

        //print_r($ticket_types);die;

        Yii::app()->params['page'] = 'Event Detail';

        $this->viewData['ticket_types'] = $ticket_types;

        $this->viewData['event'] = $event;
        $this->viewData['message'] = $this->message;
        $this->render('event', $this->viewData);
    }

    public function actionShare($s) {
        $event = $this->EventModel->get_by_slug($s);
        if (!$event)
            $this->load_404();

        Yii::app()->params['page'] = 'Share';
        $this->viewData['event'] = $event;
        $this->viewData['message'] = $this->message;
        $this->render('share', $this->viewData);
    }

    private function do_add_event_token($event) {




        $ticket_types = $_POST['ticket_type'];
        $tmp = array();
        $use_payment = 0;
        foreach ($ticket_types as $k => $v) {
            $type = $this->TicketTypeModel->get($k);
            if (!$type || $type['event_id'] != $event['id'] || $v < 1)
                continue;

            if ($type['type'] == "paid")
                $use_payment = 1;

            $tmp[] = array('type' => $type, 'quantity' => $v);
        }

        if (!$tmp)
            $this->redirect(HelperUrl::baseUrl() . "event/info/s/$event[slug]");



        $user_id = (UserControl::LoggedIn() == true) ? UserControl::getId() : "-1";

        $order_id = $this->OrderModel->add($user_id, $event['id'], Yii::app()->request->userHostAddress, Yii::app()->request->userAgent, $use_payment);
        $total = 0;
        foreach ($tmp as $k => $v) {
            //$this->OrderModel->add_detail($order_id, $v['type']['id'], $v['quantity'], $v['type']['price'], $v['type']['tax'], ($v['quantity'] * $v['type']['price']) + $v['type']['tax']);
            //$total += ($v['quantity'] * $v['type']['price']) + $v['type']['tax'];

            if ($v['type']['service_fee']) {
                $this->OrderModel->add_detail($order_id, $v['type']['id'], $v['quantity'], $v['type']['price'] * 1.1, $v['type']['tax'], ($v['quantity'] * $v['type']['price']) * 1.1);
                $total += ($v['quantity'] * $v['type']['price']) * 1.1;
            } else {
                $this->OrderModel->add_detail($order_id, $v['type']['id'], $v['quantity'], $v['type']['price'], $v['type']['tax'], ($v['quantity'] * $v['type']['price']));
                $total += ($v['quantity'] * $v['type']['price']);
            }
        }

        $token = Ultilities::base32UUID();
        $event_token_id = $this->EventModel->add_event_token($order_id, $token, time(), time() + 900, "");
        $this->OrderModel->update(array('total' => $total, 'id' => $order_id));

        if ($user_id == "-1")
            HelperGlobal::require_login(HelperUrl::baseUrl() . "event/register/?order_id=$order_id&token=$token&back=1");
        else
            $this->redirect(HelperUrl::baseUrl() . "event/register/?order_id=$order_id&token=$token");
    }

    public function actionRegister() {
        HelperGlobal::require_login();

        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
        $tmp_token = isset($_GET['token']) ? $_GET['token'] : "";
        $type = isset($_POST['payment_type']) && $_POST['payment_type'] == "direct_payment" ? "direct_payment" : "normal";

        $return = isset($_GET['back']) ? $_GET['back'] : 0;

        if ($return != 0)
            $this->OrderModel->update(array('user_id' => UserControl::getId(), 'id' => $order_id));

        $token = $this->EventModel->get_event_token($tmp_token);

        $count_down = (int) $token['date_expired'] - time();



        $order = $this->OrderModel->get($order_id);



        if (!$order || $order['user_id'] != UserControl::getId())
            $this->load_404();

        $event = $this->EventModel->get($order['event_id']);

        $user_metas = $this->UserModel->get_metas(UserControl::getId());



        if (!$event)
            $this->load_404();

        if ($order['status'] == "completed")
            $this->redirect(HelperUrl::baseUrl() . "event/info/s/$event[slug]?iok=1&msg=Thank you for joining our event.");

        if (!$token)
            $this->redirect(HelperUrl::baseUrl() . "event/info/s/$event[slug]/?wok=1&msg=Your session expired. Please try again.");


        $order_details = $this->OrderModel->get_details($order_id);

        if ($_POST && $type == "normal")
            $this->do_register($event, $order, $order_details, $token);
        else if ($_POST && $type == "direct_payment")
            $this->do_direct_payment($event, $order, $order_details, $token);

        $this->viewData['countries'] = $this->CountryModel->gets_all_countries();
        $this->viewData['order_details'] = $order_details;
        $this->viewData['event'] = $event;
        $this->viewData['user_metas'] = $user_metas;
        $this->viewData['count_down'] = $count_down;
        $this->viewData['order'] = $order;
        $this->viewData['token'] = $token;
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        //$this->viewData['world_countries'] = $this->CountryModel->gets_all_world_countries();
        Yii::app()->params['page'] = 'eTicket Payment';
        $this->render('payment_ticket', $this->viewData);
    }

    private function do_direct_payment($event, $order, $order_details, $token) {

        $usd = $this->SettingsModel->get_usd();
        $ttd = $this->SettingsModel->get_ttd();

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $address_2 = trim($_POST['address_2']);
        $city = trim($_POST['city']);
        $country = $_POST['country_id'];
        $card_type = $_POST['card_type'];
        $card_name = trim($_POST['card_name']);
        $card_number = trim($_POST['card_number']);
        $card_month = intval(trim($_POST['card_month']));
        $card_year = intval(trim($_POST['card_year']));
        $cvv_number = trim($_POST['cvv_number']);


        if ($this->validator->is_empty_string($firstname))
            $this->message['error'][] = "First name cannot be blank.";
        if ($this->validator->is_empty_string($lastname))
            $this->message['error'][] = "Last name cannot be blank.";
        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not correct format.";
        if ($this->validator->is_empty_string($phone))
            $this->message['error'][] = "Phone cannot be blank.";

        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Address cannot be blank.";
        if ($this->validator->is_empty_string($city))
            $this->message['error'][] = "City cannot be blank.";

        if (array_search($card_type, Helper::get_card_types()) === false)
            $this->message['error'][] = "Card type is not correct.";
        if ($this->validator->is_empty_string($card_name))
            $this->message['error'][] = "Card name cannot be blank.";
        if ($this->validator->is_empty_string($card_number))
            $this->message['error'][] = "Card number cannot be blank.";
        if (!$this->validator->is_credit_card($card_number))
            $this->message['error'][] = "Card number is not correct format.";
        if (!$card_month || $card_month < 1 || $card_month > 12)
            $this->message['error'][] = "Card month is not correct.";
        if (!$card_year || strlen($card_year) != 4)
            $this->message['error'][] = "Card year is not correct.";
        if ($card_month < intval(date('n')) && $card_year < intval(date('Y')))
            $this->message['error'][] = "Your card has expired.";
        if ($this->validator->is_empty_string($cvv_number))
            $this->message['error'][] = "CVV Number cannot be blank.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        //update order information

        $this->OrderModel->update(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone,
            'address' => $address,
            'address_2' => $address_2,
            'city' => $city,
            'country_id' => $country,
            'email' => $email,
            'id' => $order['id']
        ));

        $order = $this->OrderModel->get($order['id']);
        // if this order does not use payment then insert to database normally
        if ($order['use_payment'] == 0) {
            foreach ($order_details as $k => $v) {

                for ($i = 0; $i < $v['quantity']; $i++) {
                    $this->TicketModel->add_ticket($v['ticket_type_id'], $order['user_id'], "", "", "", "");
                }
            }

            $this->OrderModel->update(array('status' => 'completed', 'id' => $order['id']));
            $this->email_register_event($order, $order_details);
            $this->redirect(HelperUrl::baseUrl() . "event/info/s/$event[slug]?iok=1&msg=Thank you for joining our event.");
        } else {

            $amount = round($order['total'] * ($usd['option_value'] / $ttd['option_value']), 2);
            $currency = "USD";
            $payment_to = Yii::app()->params['business'];
            //add to tracking record
            $tracking_id = $this->TrackingModel->add('paypal', $payment_to, $currency, UserControl::getId(), $amount, 'purchase_ticket');
            $this->TrackingModel->add_meta('payment_type', 'direct_payment', $tracking_id);
            // Set request-specific fields.
            $paymentType = urlencode('Authorization');    // or 'Sale'
            $firstName = urlencode($firstname);
            $lastName = urlencode($lastname);
            $creditCardType = urlencode($card_type);
            $creditCardNumber = urlencode($card_number);
            $expDateMonth = $card_month;
// Month must be padded with leading zero
            $padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));

            $expDateYear = urlencode($card_year);
            $cvv2Number = urlencode($cvv_number);
            $address1 = urlencode($address);
            $address2 = urlencode($address_2);
            $city = urlencode($city);
            $state = urlencode("CA");
            $zip = urlencode("95131");
            $country = urlencode("US");    // US or other valid country code
            $amount = urlencode($amount);
            $currencyID = urlencode($currency);       // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
            $email = urlencode($email);
// Add request-specific fields to the request string.
            $nvpStr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber" .
                    "&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName" .
                    "&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID" .
                    "&EMAIL=$email";

// Execute the API operation; see the PPHttpPost function above.
            $httpParsedResponseAr = $this->PPHttpPost('DoDirectPayment', $nvpStr);

            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {


                $paypal_id = $this->PaypalModel->add($httpParsedResponseAr['TRANSACTIONID'], $tracking_id, $amount, serialize($httpParsedResponseAr));
                $this->TrackingModel->update(array('ref_id' => $paypal_id, 'txn_id' => $httpParsedResponseAr['TRANSACTIONID'], 'completed' => 1, 'id' => $tracking_id));
                $tickets = array();
                foreach ($order_details as $k => $v) {

                    for ($i = 0; $i < $v['quantity']; $i++) {
                        $tickets[$v['id']][] = $this->TicketModel->add_ticket($v['ticket_type_id'], $order['user_id'], "", "", "", "", $order['id']);
                    }
                }

                $this->OrderModel->update(array('status' => 'completed', 'id' => $order['id']));
                $this->email_register_event($order, $order_details, $tickets);
                $this->redirect(HelperUrl::baseUrl() . "event/register/?order_id=$order[id]&token=$token[token]");
                //exit('Direct Payment Completed Successfully: '.print_r($httpParsedResponseAr, true));
            } else {
                //exit('DoDirectPayment failed: ' . "<pre>" . print_r($httpParsedResponseAr, true) . "</pre>");
                $this->message['error'][] = urldecode($httpParsedResponseAr['L_LONGMESSAGE0']);
            }
        }
    }

    private function PPHttpPost($methodName_, $nvpStr_) {
        $environment = 'live'; // or sandbox or 'beta-sandbox' or 'live'
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = urlencode(Yii::app()->params['paypal_api_username']);
        $API_Password = urlencode(Yii::app()->params['paypal_api_password']);
        $API_Signature = urlencode(Yii::app()->params['paypal_api_signature']);
        $API_Endpoint = "https://api-3t.paypal.com/nvp";
        if ("sandbox" === $environment || "beta-sandbox" === $environment) {
            $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
        }
        $version = urlencode('51.0');

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

    private function do_register($event, $order, $order_details, $token) {

        $usd = $this->SettingsModel->get_usd();
        $ttd = $this->SettingsModel->get_ttd();

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $address_2 = trim($_POST['address_2']);
        $city = trim($_POST['city']);
        $country = $_POST['country_id'];


        if ($this->validator->is_empty_string($firstname))
            $this->message['error'][] = "First name cannot be blank.";
        if ($this->validator->is_empty_string($lastname))
            $this->message['error'][] = "Last name cannot be blank.";
        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not correct format.";
        if ($this->validator->is_empty_string($phone))
            $this->message['error'][] = "Phone cannot be blank.";

        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Address cannot be blank.";
        if ($this->validator->is_empty_string($city))
            $this->message['error'][] = "City cannot be blank.";


        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        //update order information

        $this->OrderModel->update(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone,
            'address' => $address,
            'address_2' => $address_2,
            'city' => $city,
            'country_id' => $country,
            'email' => $email,
            'id' => $order['id']
        ));

        $order = $this->OrderModel->get($order['id']);
        // if this order does not use payment then insert to database normally
        if ($order['use_payment'] == 0) {
            foreach ($order_details as $k => $v) {

                for ($i = 0; $i < $v['quantity']; $i++) {
                    $this->TicketModel->add_ticket($v['ticket_type_id'], $order['user_id'], "", "", "", "");
                }
            }

            $this->OrderModel->update(array('status' => 'completed', 'id' => $order['id']));
            $this->email_register_event($order, $order_details);
            $this->redirect(HelperUrl::baseUrl() . "event/info/s/$event[slug]?iok=1&msg=Thank you for joining our event.");
        } else {
            //if this order use payment then process to paypal

            $payment_to = Yii::app()->params['business'];
            $currency = 'USD';
            $amount = round($order['total'] * ($usd['option_value'] / $ttd['option_value']), 2);
            $tracking_id = $this->TrackingModel->add('paypal', $payment_to, $currency, UserControl::getId(), $amount, 'purchase_ticket');
            $this->TrackingModel->add_meta('payment_type', 'normal', $tracking_id);

            $return_url = HelperUrl::baseUrl(true) . "event/register/?order_id=$order[id]&token=$token[token]";
            $cancel_url = HelperUrl::baseUrl(true) . "event/register/?order_id=$order[id]&token=$token[token]";
            $notify_url = HelperUrl::baseUrl(true) . "event/process_paypal/";

            $queryStr = "?business=" . urlencode($payment_to);

            $data = array('item_name' => "Purchase ticket of event : " . $event['title'] . ".",
                'amount' => $amount,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'payer_email' => $email,
                'cmd' => '_xclick',
                'no_note' => '1',
                'lc' => 'US',
                'currency_code' => $currency,
                'item_number' => $order['id'],
                'return' => $return_url,
                'cancel_return' => $cancel_url,
                'custom' => $tracking_id,
                'quantity' => 1,
                'notify_url' => $notify_url);
            foreach ($data as $key => $value) {
                $value = urlencode(stripslashes($value));
                $queryStr .= "&$key=$value";
            }

            //$this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr' . $queryStr);
            $this->redirect('https://www.paypal.com/cgi-bin/webscr' . $queryStr);
            die;
        }
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


        if ($_POST['test_ipn'] == 1)
            exit();
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
        //$fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);


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

                $order = $this->OrderModel->get($data['item_number']);
                $order_details = $this->OrderModel->get_details($order['id']);
                $tickets = array();
                foreach ($order_details as $k => $v) {

                    for ($i = 0; $i < $v['quantity']; $i++) {
                        $tickets[$v['id']][] = $this->TicketModel->add_ticket($v['ticket_type_id'], $order['user_id'], "", "", "", "", $order['id']);
                    }
                }

                $this->OrderModel->update(array('status' => 'completed', 'id' => $order['id']));
                $this->email_register_event($order, $order_details, $tickets);
            }
        }
        fclose($fp);
        exit();
    }

    public function actionTest() {
        //echo '<img src="http://api.qrserver.com/v1/create-qr-code/?data=' . HelperUrl::baseUrl() . '&amp;size=280x280" />';die;
        echo $this->get_qrcode(HelperUrl::baseUrl(true) . '&size=280x280');
    }

    private function email_register_event($order, $order_details, $tickets) {
        $event = $this->EventModel->get($order['event_id']);

        /*
          $message = '<p style="margin-bottom:10px">Dear ' . $order['firstname'] . ', </p>

          <p style="margin-bottom:10px">Thank you for joining our event: ' . $event['title'] . ' </p>
          <p style="margin-bottom:10px">We hope you enjoyt it. </p>

          <p>Here are the qrcodes for attending our events: </p>


          '; */

        $email_template = $this->EmailModel->get_by_slug('ticket-payment');
        $message = $email_template['content'];
        $list_qrcodes = "";
        foreach ($order_details as $k => $v) {

            //$message.= ($k + 1) . '. ' . $v['title'];
            $tmp_tickets = $tickets[$v['id']];
            foreach ($tmp_tickets as $t) {
                $random_key = Ultilities::base32UUID();
                $url = HelperUrl::baseUrl(true) . "event/attend/eid/$order[event_id]/tid/$t/key/$random_key" . "&size=280x280";
                $qrcode = $this->get_qrcode(array('url' => $url, 'ticket_id' => $t, 'name' => $order['lastname'] . " " . $order['firstname'], 'event_title' => $event['title'], 'ticket_type_title' => $v['title'],'random_key'=>$random_key));
                $list_qrcodes.= ' <img style="margin-right:10px" src="' . $qrcode . '" alt="' . $v['title'] . '" title="' . $v['title'] . '" /> <br/> <br/>';
            }
        }

        //$message.= '<br/><br/>';

        $replace = array('$firstname', '$event_title', '$list_qrcodes');
        $data = array($order['firstname'], $event['title'], $list_qrcodes);
        $message = str_replace($replace, $data, $message);

        HelperApp::email($order['email'], $email_template['title'], $message);
    }

    private function get_qrcode($args) {
        $qrcode = 'http://api.qrserver.com/v1/create-qr-code/?data=' . $args['url'];
        $filename = Ultilities::base32UUID() . ".png";
        $flag = @file_put_contents(HelperUrl::upload_dir() . "qrcode/$filename", file_get_contents($qrcode));

        if (!$flag)
            return "";
        $filepath = HelperUrl::upload_dir() . "qrcode/$filename";
        $args['qrcode'] = $filepath;
        $simpleImage = new SimpleImage();
        $simpleImage->mergeImageQRCode(280, $args);
        $simpleImage->save_with_default_imagetype($filepath);
        $this->TicketModel->update(array('qrcode' => $filename,'random_key'=>$args['random_key'], 'id' => $args['ticket_id']));
        return HelperUrl::hostInfo() . HelperUrl::upload_url() . "qrcode/$filename";
    }

    public function actionSearch($p = 1) {

        $s = isset($_GET['title']) ? $_GET['title'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $cate = isset($_GET['cate']) ? $_GET['cate'] : "";
        $date = isset($_GET['date']) ? $_GET['date'] : "";
        $country = isset($_GET['country']) ? $_GET['country'] : "";
        //$country = strlen($country) > 2 ? $country : "";
//        $price = isset($_GET['price']) ? $_GET['price'] : "";
//        $cid = isset($_GET['cid']) ? $_GET['cid'] : "";
//        $oid = isset($_GET['oid']) ? $_GET['oid'] : "";
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        if ($country == 0) {
            $args = array('search_title' => $s, 'search_cate' => $cate, 'date' => $date);
        } else {
            $args = array('search_title' => $s, 'search_city' => $country, 'search_cate' => $cate, 'date' => $date);
        }
        $events = $this->EventModel->gets($args, $p, $ppp);
        $total = $this->EventModel->counts($args);

        //print_r($events);die;

        $event_categories = $this->CategoryModel->gets(array('deleted' => 0, 'type' => 'event'));
        $event_country = $this->LocationModel->gets(array('deleted' => 0));

//        if ($s || $country)
//            $this->KeywordModel->add($s, $country, 0, time());

        $this->viewData['events'] = $events;
        $this->viewData['total'] = $total;
        $this->viewData['event_categories'] = $event_categories;
        $this->viewData['event_country'] = $event_country;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, HelperUrl::baseUrl() . "event/search/p/", $total, $p) : "";
        $this->viewData['query_string'] = $this->get_query_string();
        Yii::app()->params['page'] = "Find Events";
        $this->render('search', $this->viewData);
    }

    public function actionAttend($eid, $tid,$key) {
        $event = $this->EventModel->get($eid);

        if (!$event) {
            echo "PERMISSION DENIED";
            die;
        }

        $ticket = $this->TicketModel->get($tid);
        if (!$ticket || $ticket['event_id'] != $eid || $ticket['random_key'] == "" || $ticket['random_key'] != $key) {
            echo "PERMISSION DENIED";
            die;
        }
        
        if($ticket['is_used'])
        {
            echo "THIS TICKET HAS ALREADY USED.";
            die;
        }
        
        $this->TicketModel->update(array('is_used'=>1,'id'=>$tid));

        $message = '<h2>Permission Accepted</h2> <br/><br/>
                    <h3>Event: ' . $event['title'] . ' </h3>
                    <h3>Ticket: #' . $ticket['id'] . ' - ' . $ticket['ticket_type_title'] . '</h3>
                    ';

        echo $message;
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

    public function ActionUpload_logo_event() {
        HelperGlobal::require_login();

        $temp_file = $_POST['file_temp'];
        if ($temp_file != '')
            @unlink($temp_file);

        $file = $_FILES['file'];

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file, 2097152))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(1920, 1080, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            echo json_encode(array('message' => $this->message));
            die;
        }


        // check if has thumbnail
        if (!$this->validator->is_empty_string($file['name'])) {
            $file_upload = HelperApp::upload_files($file, 2097152, "temp/" . date('Y') . '/' . date('m') . '/');
            echo json_encode(array('message' => $this->message, 'data' => array('url' => $file_upload[0]['url'], 'name' => $file_upload[0]['name'])));
            die;
        }
    }

    public function actionInvite($s) {
        $event_link = HelperUrl::baseUrl() . 'event/info/s/' . $s;
        $message = "";
        /*
        $message = '
                
                        <p style="margin-bottom: 10px;margin-top:0">Have a invite Event</p>
                        <p style="margin-bottom: 10px;margin-top:0"><a href=' . $link . '>Click here</a> to view</p>
                        
        ';
        */
        
        $email_template = $this->EmailModel->get_by_slug('event-invite');
        
        $replace = array('$event_link');
        $data = array($event_link);
        $message = str_replace($replace, $data, $message);        
        
        @HelperApp::email(UserControl::getEmail(), $email_template['title'], $message);
        $this->redirect(HelperUrl::baseUrl() . "event/share/s/$s");
    }

}