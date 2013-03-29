<?php

class UserController extends Controller {

    private $viewData;
    private $validator;
    private $message = array('success' => true, 'error' => array());
    private $UserModel;
    private $CountryModel;
    private $OrganizerModel;
    private $EventModel;
    private $TicketModel;
    private $OrderModel;
    private $TicketTypeModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();

        /* @var $CountryModel CountryModel */
        $this->CountryModel = new CountryModel();


        /* @var $OrganizerModel OrganizerModel */
        $this->OrganizerModel = new OrganizerModel();


        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();

        /* @var $TicketModel TicketModel */
        $this->TicketModel = new TicketModel();

        /* @var $OrderModel OrderModel */
        $this->OrderModel = new OrderModel();
        
         /* @var $TicketTypeModel TicketTypeModel */
        $this->TicketTypeModel = new TicketTypeModel();
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

    public function actionSignout() {
        UserControl::DoLogout();
        $this->redirect(HelperUrl::baseUrl() . "home/");
    }

    public function actionSignup() {

        if ($_POST)
            $this->do_signup();

        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = 'Register';
        $this->render('signup', $this->viewData);
    }

    private function do_signup() {
        $pattern = '/^[A-Za-z0-9]+(?:[_][A-Za-z0-9]+)*$/';
        $special_char = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        $email = trim($_POST['email']);
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $address = trim($_POST['address']);
        $address2 = trim($_POST['address2']);
        $is_session = isset($_POST['remember']) ? false : true;
        $city = trim($_POST['city']);
        $country_id = trim($_POST['country']);
        $client = isset($_POST['client']) ? 'waiting' : 'customer';

        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not correct.";
        if ($this->UserModel->is_existed_email($email))
            $this->message['error'][] = "Email is exists.";
        if ($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "Password cannot be blank.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Password must be length 6-20 characters";
        if ($pwd1 != $pwd2)
            $this->message['error'][] = "Password is not match.";
        if ($this->validator->is_empty_string($firstname))
            $this->message['error'][] = "Firstname cannot be blank.";
        if (preg_match($special_char, $firstname))
            $this->message['error'][] = "Firstname must not contains any speacial characters.";
        if ($this->validator->is_empty_string($lastname))
            $this->message['error'][] = "Lastname cannot be blank.";
        if (preg_match($special_char, $lastname))
            $this->message['error'][] = "Lastname must not contains any speacial characters.";
        if ($this->validator->is_empty_string($address))
            $this->message['error'][] = "Address cannot be blank.";
        if (preg_match($special_char, $address))
            $this->message['error'][] = "Address must not contains any speacial characters.";
        if (preg_match($special_char, $address2))
            $this->message['error'][] = "Address 2 must not contains any speacial characters.";
        if ($this->validator->is_empty_string($city))
            $this->message['error'][] = "City cannot be blank.";
        if (preg_match($special_char, $city))
            $this->message['error'][] = "City must not contains any speacial characters.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $hasher = new PasswordHash(10, TRUE);
        $password = $hasher->HashPassword($pwd1);
        $secret_key = Ultilities::base32UUID();

        $user_id = $this->UserModel->add($email, $password, $secret_key, $firstname, $lastname, $country_id, $client, 0);

        $this->UserModel->add_meta('city', $city, $user_id);
        $this->UserModel->add_meta('address', $address, $user_id);
        $this->UserModel->add_meta('address2', $address2, $user_id);

        $this->OrganizerModel->add($user_id);
        HelperApp::add_cookie('secret_key', $secret_key, $is_session);
        $this->redirect(HelperUrl::baseUrl() . "home/");
    }

    public function actionSignin() {

        if ($_POST)
            $this->do_signin();

        Yii::app()->params['page'] = 'Login';
        $this->viewData['message'] = $this->message;
        $this->render('signin', $this->viewData);
    }

    private function do_signin() {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $is_session = isset($_POST['remember']) ? false : true;
        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not correct.";
        if ($this->validator->is_empty_string($password))
            $this->message['error'][] = "Password cannot be blank.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $user = $this->UserModel->get_by_email($email);
        if (!$user) {
            $this->message['error'][] = "Email or password is not correct.";
            $this->message['success'] = false;
            return false;
        }

        $hasher = new PasswordHash(10, TRUE);
        if (!$hasher->CheckPassword($password, $user['password'])) {
            $this->message['error'][] = "Email or password is not correct.";
            $this->message['success'] = false;
            return false;
        }

        HelperApp::add_cookie('secret_key', $user['secret_key'], $is_session);
        $url = isset($_GET['return']) ? $_GET['return'] : HelperUrl::baseUrl() . "home/";
        $this->redirect($url);
    }

    public function actionForgot() {
        if ($_POST)
            $this->do_forgot();

        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = 'Recovery Password';
        $this->render('recovery-password', $this->viewData);
    }

    private function do_forgot() {
        $email = trim($_POST['email']);
        $user = $this->UserModel->get_by_email($email);
        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not corrent.";
        if (!$user)
            $this->message['error'][] = "Email is not exists.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $token = Ultilities::base32UUID();
        $date_added = time();
        $date_expired = $date_added + (Yii::app()->getParams()->itemAt('token_time')) * 86400;

        $this->UserModel->add_token($token, $user['id'], 'password', $date_added, $date_expired);
        $msg = "Please check your email. We just sent you an email with a link to setup your new password.";

        $forgot_url = Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . "/user/reset/t/$token";
        $to = $email;
        $subject = "Recovery Password";
        $message = 'Hello <strong>' . $user['firstname'] . ' ' . $user['lastname'] . '</strong>, <br /><br />
                    Has requested get back password at 360 Island Events website.
                    If this is you, please click on the link below to continue.
                    If not, please ignore this email.<br/><br />
                    <a href="' . $forgot_url . '">' . $forgot_url . '</a><br/><br/>                   
                    ';

        HelperApp::email($to, $subject, $message);
        $this->redirect(HelperUrl::baseUrl() . "user/forgot/?s=1&msg=$msg");
    }

    public function actionReset($t = "") {
        if ($this->validator->is_empty_string($t))
            $this->redirect(HelperUrl::baseUrl() . "user/forgot/");

        $token = $this->UserModel->get_token($t);

        if (!$token)
            $this->message['success'] = false;
        if ($_POST)
            $this->do_reset($token);
        $this->viewData['token'] = $token;
        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = 'New Password';
        $this->render('new-password', $this->viewData);
    }

    private function do_reset($token) {
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);

        if ($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "Password can not be blank.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Password must be length 6-20 characters";
        if ($pwd1 != $pwd2)
            $this->message['error'][] = "Password is not match.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }
        $haser = new PasswordHash(10, true);
        $password = $haser->HashPassword($pwd1);

        $this->UserModel->update_token($token['id']);
        $this->UserModel->update(array('password' => $password, 'id' => $token['user_id']));
        $this->redirect(HelperUrl::baseUrl() . "user/signin/");
    }

    public function actionAccount($type = "setting", $p = 1, $id = "") {

        $this->layout = 'account';
        switch ($type) {
            case "setting":
                $this->account_setting($type);
                break;
            case "manage_event":
                $this->manage_event($type, $p);
                break;
            case "paid_event":
                $this->paid_event($type);
                break;
            case "change_password":
                $this->change_password($type);
                break;
        }
    }

    private function account_setting($type) {
        HelperGlobal::require_login();
        if ($_POST)
            $this->do_account_setting();

        $this->viewData['countries'] = $this->CountryModel->gets_all_countries();
        $this->viewData['metas'] = $this->UserModel->get_metas(UserControl::getId());
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = 'Account Setting';
        Yii::app()->params['is_tab'] = 'setting';
        $this->render('account-setting', $this->viewData);
    }

    private function do_account_setting() {
        $file = $_FILES['file'];
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $address = trim($_POST['address']);
        $address2 = trim($_POST['address2']);
        
        $city = $_POST['city'];
        $country_id = $_POST['country_id'];

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file, 1048576))
            $this->message['error'][] = "Image or size is not correct.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Minimum image size is 300x300px.";
        if ($this->validator->is_empty_string($firstname) || $this->validator->has_speacial_character($firstname))
            $this->message['error'][] = "Firstname can not be blank and not contains any speacial characters.";
        if ($this->validator->is_empty_string($lastname) || $this->validator->has_speacial_character($lastname))
            $this->message['error'][] = "Lastname can not be blank and not contains any speacial characters.";
        if ($this->validator->is_empty_string($city) || $this->validator->has_speacial_character($city))
            $this->message['error'][] = "City can not be blank and not contains any speacial characters.";
        if ($this->validator->is_empty_string($address) || $this->validator->has_speacial_character($address))
            $this->message['error'][] = "Address 1 can not be blank and not contains any speacial characters.";
        if ($this->validator->has_speacial_character($address2))
            $this->message['error'][] = "Address 2 can not be blank and not contains any speacial characters.";  

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $img = UserControl::getImg();
        $thumbnail = UserControl::getThumbnail();

        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_avatar_sizes(), $img);
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }


        $this->UserModel->update(array('img' => $img, 'thumbnail' => $thumbnail, 'country_id' => $country_id, 'firstname' => $firstname, 'lastname' => $lastname,'id' => UserControl::getId()));

        //update metas
        $this->UserModel->update_metas('address', $address, UserControl::getId());
        $this->UserModel->update_metas('address2', $address2, UserControl::getId());
        $this->UserModel->update_metas('phone', trim($_POST['phone']), UserControl::getId());
        $this->UserModel->update_metas('city', $city, UserControl::getId());

        $this->redirect(HelperUrl::baseUrl() . "user/account/type/setting/?s=1");
    }

    private function manage_event($type, $p = 1) {
        HelperGlobal::require_login();

        if ($_POST)
            $this->send_email();


        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        $args = array('user_id' => UserControl::getId(), 's' => $s, 'deleted' => 0);

        $events = $this->EventModel->gets($args);
        $total = $this->EventModel->counts($args);

        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = 'Management Event';
        Yii::app()->params['is_tab'] = 'manage_event';

        $this->viewData['total'] = $total;
        $this->viewData['events'] = $events;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/event/index/p/", $total, $p) : "";


        $this->render('manage_event', $this->viewData);
    }

    private function send_email() {
        $emails = $_POST['email'];
        $message = $_POST['message'];
        $subject = $_POST['subject'];

        $email = explode(';', $emails);
        foreach ($email as $k => $e) {
            HelperApp::email($e, $subject, $message);
        }
        $this->redirect(HelperUrl::baseUrl() . "user/account/type/manage_event/?s=1");
    }

    private function paid_event($p = 1) {

        HelperGlobal::require_login();
        if ($_POST)
            $this->do_paid_event();

        $args = array('user_id' => UserControl::getId(), 'status' => 'completed');
        $orders = $this->OrderModel->gets($args);
        $total = $this->OrderModel->counts($args);

        $this->viewData['message'] = $this->message;
        $this->viewData['orders'] = $orders;
        $this->viewData['total'] = $total;
        Yii::app()->params['page'] = "Paid Event's ticket";
        Yii::app()->params['is_tab'] = 'paid_event';
        $this->render('paid_event', $this->viewData);
    }

    public function actionOrder($id = 0) {
        HelperGlobal::require_login();
        $this->layout = 'account';
        $order = $this->OrderModel->get($id);
        if (!$order || $order['user_id'] != UserControl::getId())
            $this->load_404();

        $order_details = $this->OrderModel->get_details($id);

        Yii::app()->params['page'] = "Order #$id";
        Yii::app()->params['is_tab'] = 'paid_event';

        $this->viewData['order'] = $order;
        $this->viewData['order_details'] = $order_details;

        $this->render('order-detail', $this->viewData);
    }

    public function actionTicket($id) {
        $this->layout = 'account';
        $ticket_type = $this->TicketModel->get_ticket_by_user(UserControl::getId(), $id);
        $this->viewData['ticket_type'] = $ticket_type;

        Yii::app()->params['page'] = "Ticket Detail";
        Yii::app()->params['is_tab'] = 'paid_event';
        $this->render('ticket', $this->viewData);
    }

    private function do_paid_event() {
        $this->redirect(HelperUrl::baseUrl() . "user/account/type/paid_event/?s=1");
    }

    private function change_password($type) {
        HelperGlobal::require_login();

        if ($_POST)
            $this->do_change_password();
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = "Change Password";
        Yii::app()->params['is_tab'] = 'change_password';
        $this->render('change-password', $this->viewData);
    }

    private function do_change_password() {

        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);

        $hasher = new PasswordHash(10, TRUE);
        
        if (UserControl::getIs_signup_facebook() == 0) {
            $oldpwd = trim($_POST['oldpwd']);
            if ($this->validator->is_empty_string($oldpwd))
                $this->message['error'][] = "Password cannot be blank.";

            if (!$hasher->CheckPassword($oldpwd, UserControl::getPassword()))
                $this->message['error'][] = "Current password is not match.";
        }
        
        
        if ($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "New password cannot be blank.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Password must be length 6-20 characters";
        if ($pwd1 != $pwd2)
            $this->message['error'][] = "New password is not match";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $password = $hasher->HashPassword($pwd1);
        $this->UserModel->update(array('password' => $password, 'id' => UserControl::getId()));

        $this->redirect(HelperUrl::baseUrl() . "user/account/type/change_password/?s=1");
    }

    public function actionMake_profile() {
        HelperGlobal::require_login();

        if (UserControl::getRole() != 'client')
            $this->load_404();

        $organizer = $this->OrganizerModel->get_by_user(UserControl::getId());

        if ($_POST)
            $this->do_make_profile($organizer);

        $this->viewData['organizer'] = $organizer;
        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = "Make Profile";
        $this->render('make-profile', $this->viewData);
    }

    private function do_make_profile($organizer) {

        $title = trim($_POST['title']);
        $file = $_FILES['file'];
        $description = trim($_POST['description']);
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter Organizer name.";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $img = $organizer['img'];
        $thumbnail = $organizer['thumbnail'];

        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_organizer_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        $this->OrganizerModel->update(array('title' => $title, 'last_modified' => time(), 'img' => $img, 'thumbnail' => $thumbnail, 'description' => $description, 'id' => $organizer['id']));
        $this->redirect(HelperUrl::baseUrl() . "user/make_profile/?s=1");
    }

    public function actionView_profile($s = 'current', $u = '', $p = 1) {

        if ($u == '')
            $this->load_404();

        $ppp = 10;
        $list_events = $this->EventModel->get_all_by_user($u, $p, $ppp);
        $user = $this->UserModel->get($u);

        $total = $this->EventModel->count_all_by_user($u);

        if ($user['id'] == UserControl::getId())
            $page_title = 'My Profile';
        else
            $page_title = $user['firstname'] . ' ' . $user['lastname'] . "'s Profile";

        $this->viewData['user'] = $user;
        $this->viewData['list_events'] = $list_events;
        $this->viewData['message'] = $this->message;
        $this->viewData['total'] = $total;
        $this->viewData['current_tab'] = $s;
        Yii::app()->params['page'] = $page_title;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, HelperUrl::baseUrl() . "user/view_profile/s/$s/u/$u/p/", $total, $p) : "";
        $this->render('view-profile', $this->viewData);
    }

    public function actionLoginfacebook() {
        $app_id = "104204896436938";
        $app_secret = "d6a281b62853338ba8d41fdf4c5df216";
        $my_url = HelperUrl::baseUrl(true) . "user/loginfacebook/";
        session_start();


        $code = $_REQUEST["code"];
        if (empty($code)) {
            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
            $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
                    . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
                    . $_SESSION['state'] . "&scope=read_stream,email,publish_actions";

            header("Location: " . $dialog_url);
        }

        if ($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {

            $token_url = "https://graph.facebook.com/oauth/access_token?"
                    . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                    . "&client_secret=" . $app_secret . "&code=" . $code;

            $response = file_get_contents($token_url);
            $params = null;
            parse_str($response, $params);

            $_SESSION['access_token'] = $params['access_token'];

            $graph_url = "https://graph.facebook.com/me?access_token="
                    . $params['access_token'];

            $user_info = json_decode(file_get_contents($graph_url));

            $this->checkloginfacebook($user_info);
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
        }
    }

    private function checkloginfacebook($user_info) {

        $user = $this->UserModel->get_by_email($user_info->email);
        if (!$user) {
            $secret_key = Ultilities::base32UUID();
            $user_id = $this->UserModel->add($user_info->email, '', $secret_key, $user_info->name, '', 1, 'customer', 1);
            HelperApp::add_cookie('secret_key', $secret_key, $is_session);
            $this->redirect(Yii::app()->request->baseUrl . "/home/");
        } else {
            HelperApp::add_cookie('secret_key', $user['secret_key'], $is_session);
            $url = isset($_GET['return']) ? $_GET['return'] : Yii::app()->request->baseUrl . "/home/";
            $this->redirect($url);
        }
    }

    
    public function actionEvent_view_info($id){
        HelperGlobal::require_login();
        
        $event = $this->EventModel->get($id);
        
        if(!$event)
            $this->load_404 ();
        if($event['user_id'] != UserControl::getId())
            $this->load_404 ();
        
        $event_all_tickets_sold = $this->TicketTypeModel->gets(array('event_id'=>$event['id']),1,300);
        
        $this->viewData['event_all_tickets_sold'] = $event_all_tickets_sold;

        Yii::app()->params['is_tab'] == 'manage_event';
        Yii::app()->params['page'] = 'Management Event';
        $this->layout = 'account';
        $this->render('view_event_info', $this->viewData);
        
    }
}