<?php

class UsersController extends Controller {

    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $viewData;
    private $UserModel;
    private $AuthTokenModel;
    private $EventModel;
    private $OrganizerModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();

        /* @var $AuthTokenModel AuthTokenModel */
        $this->AuthTokenModel = new AuthTokenModel();
        
        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();
        
        /* @var $OrganizerModel OrganizerModel */
        $this->OrganizerModel = new OrganizerModel();
    }

    public function actionCode_access() {
        die;
        $str = "eTicket";
        $base = "2013";
        //echo base64_encode($base);
        echo sha1(sha1($str) . $base);

        //for generate apikey of user
        $apikey = "dMxK3uFUh" . Ultilities::base32UUID();
        echo sha1(base64_encode($apikey));
    }

    public function actionSignin() {
        HelperGlobal::CheckAccessToken();
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $os_version = trim($_POST['os_version']);
        $os_name = trim($_POST['os_name']);
        $device_name = trim($_POST['device_name']);

        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email does not correct format.";
        if ($this->validator->is_empty_string($password))
            $this->message['error'][] = "Password cannot be blank.";

        if (count($this->message['error']) > 0) {
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }

        $user = $this->UserModel->get_by_email($email);
        if (!$user) {
            $this->message['error'][] = "Email or Password does not correct.";
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }

        $hasher = new PasswordHash(10, TRUE);
        if (!$hasher->CheckPassword($password, $user['password'])) {
            $this->message['error'][] = "Email or Password does not correct.";
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }
        $token = Helper::gen_access_token();
        $this->AuthTokenModel->add($user['id'], $token, $os_version, $os_name, $device_name);
        HelperGlobal::return_data(array('access_token' => $token, 'user' => HelperGlobal::user_info($user)), array('code' => 200, 'message' => $this->message['error']));
    }

    public function actionSignup() {
        HelperGlobal::CheckAccessToken();
        $pattern = '/^[A-Za-z0-9]+(?:[_][A-Za-z0-9]+)*$/';
        $special_char = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        $email = trim($_POST['email']);
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $address = trim($_POST['address']);
        $address2 = trim($_POST['address2']);
        $city = trim($_POST['city']);
        $phone = trim($_POST['phone']);
        $country_id = trim($_POST['country']);
        $client = isset($_POST['client']) ? 'waiting' : 'customer';

        $os_version = trim($_POST['os_version']);
        $os_name = trim($_POST['os_name']);
        $device_name = trim($_POST['device_name']);

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
        if ($this->validator->is_empty_string($city))
            $this->message['error'][] = "City cannot be blank.";
        if (preg_match($special_char, $city))
            $this->message['error'][] = "City must not contains any speacial characters.";

        if (count($this->message['error']) > 0) {
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }

        $hasher = new PasswordHash(10, TRUE);
        $password = $hasher->HashPassword($pwd1);
        $secret_key = Ultilities::base32UUID();

        $user_id = $this->UserModel->add($email, $password, $secret_key, $firstname, $lastname, $country_id, $client, 0);
        $user = $this->UserModel->get($user_id);
        $this->UserModel->add_meta('city', $city, $user_id);
        $this->UserModel->add_meta('address', $address, $user_id);
        $this->UserModel->add_meta('address2', $address2, $user_id);
        $this->UserModel->add_meta('phone', $phone, $user_id);
        $this->OrganizerModel->add($user_id);

        $token = Helper::gen_access_token();
        $this->AuthTokenModel->add($user_id, $token, $os_version, $os_name, $device_name);
        HelperGlobal::return_data(array('access_token' => $token, 'user' => HelperGlobal::user_info($user)), array('code' => 200, 'message' => $this->message['error']));
    }

    public function actionForgot() {
        HelperGlobal::CheckAccessToken();
        $email = trim($_POST['email']);
        $user = $this->UserModel->get_by_email($email);
        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not corrent.";
        if (!$user)
            $this->message['error'][] = "Email is not exists.";

        if (count($this->message['error']) > 0) {
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
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
                        
                    If you use mobile devices to get back your password. Here your key: ' . $token . '
                    ';

        HelperApp::email($to, $subject, $message);
        HelperGlobal::return_data(array(), array('code' => 200, 'message' => "Please check your email."));
    }

    public function actionReset() {
        HelperGlobal::CheckAccessToken();
        $token = trim($_POST['token']);        
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        if ($this->validator->is_empty_string($token))
        {
            $this->message['error'][] = "Token is not correct.";
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }

        $token = $this->UserModel->get_token($token);
        
        if(!$token)
            $this->message['error'][] = "Token is not correct.";

        if ($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "Password can not be blank.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Password must be length 6-20 characters.";
        if ($pwd1 != $pwd2)
            $this->message['error'][] = "Password is not match.";

        if (count($this->message['error']) > 0) {
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }
        $haser = new PasswordHash(10, true);
        $password = $haser->HashPassword($pwd1);

        $this->UserModel->update_token($token['id']);
        $this->UserModel->update(array('password' => $password, 'id' => $token['user_id']));
        HelperGlobal::return_data(array(), array('code' => 200, 'message' => "Change password successfully"));
    }
    
    public function actionEvents(){
        HelperGlobal::CheckAccessToken(true);
        $access_token = isset($_GET['access_token']) ? $_GET['access_token'] : "";
        $token = $this->AuthTokenModel->get_by_token($access_token);
        $user = $this->UserModel->get($token['user_id']);
        
        $args = array('user_id' => $user['id'], 'deleted' => 0);

        $events = $this->EventModel->gets($args,1,20);
        foreach($events as $k=>$v){
            $events[$k]['thumbnail'] = unserialize($events[$k]['thumbnail']);
        }
        $total = $this->EventModel->counts($args);
        
        $this->viewData['events'] = $events;
        $this->viewData['total_event'] = $total;
        $this->viewData['user'] = HelperGlobal::user_info($user);
        HelperGlobal::return_data(array($this->viewData), array('code' => 200, 'message' => ""));
    }

}