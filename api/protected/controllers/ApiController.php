<?php

class ApiController extends Controller {

    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $viewData;
    private $UserModel;
    private $AuthTokenModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();

        /* @var $AuthTokenModel AuthTokenModel */
        $this->AuthTokenModel = new AuthTokenModel();
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
        $email = trim($_POST['email']);
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        $fullname = trim($_POST['fullname']);       
        $os_version = trim($_POST['os_version']);
        $os_name = trim($_POST['os_name']);
        $device_name = trim($_POST['device_name']);

        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email does not correct format.";
        if ($this->UserModel->is_existed_email($email))
            $this->message['error'][] = "This email has already existed.";
        if ($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "Password cannot be blank.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Password's length minimum 6 letters, maximum 20 letters.";
        if ($pwd1 != $pwd2)
            $this->message['error'][] = "Password and Confirm password do not match.";
        if ($this->validator->is_empty_string($fullname))
            $this->message['error'][] = "Fullname cannot be blank.";
        if ($this->validator->has_speacial_character($fullname))
            $this->message['error'][] = "Fullname does not contains any speacial characters.";

        if (count($this->message['error']) > 0) {
            HelperGlobal::return_data(array(), array('code' => 4, 'message' => $this->message['error']));
        }

        $hasher = new PasswordHash(10, TRUE);
        $password = $hasher->HashPassword($pwd1);
        $secret_key = Ultilities::base32UUID();

        $user_id = $this->UserModel->add($email, $password, $secret_key, $fullname);   
        $user = $this->UserModel->get($user_id);
        $token = Helper::gen_access_token();
        $this->AuthTokenModel->add($user_id, $token, $os_version, $os_name, $device_name);
        HelperGlobal::return_data(array('access_token' => $token, 'user' => HelperGlobal::user_info($user)), array('code' => 200, 'message' => $this->message['error']));
    }

}