<?php

class UserController extends Controller {
    
    private $viewData;
    private $validator;
    private $message = array('success' => true, 'error' => array());
    private $UserModel;
    
    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();
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
        $this->render('index',$this->viewData); 
    }   
    
    public function actionSignup() {  
        
        if ($_POST)
            $this->do_signup();
        
        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = 'Register';
        $this->render('signup',$this->viewData); 
    }  
    
    private function do_signup() {
        $pattern = '/^[A-Za-z0-9]+(?:[_][A-Za-z0-9]+)*$/';
        $special_char = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        $email = trim($_POST['email']);
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $is_session = isset($_POST['remember']) ? false : true;
        $city_id = trim($_POST['city']);
        $client = isset($_POST['client'])? 'waiting' : 'customer';

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

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $hasher = new PasswordHash(10, TRUE);
        $password = $hasher->HashPassword($pwd1);
        $secret_key = Ultilities::base32UUID();

        $user_id = $this->UserModel->add($email, $password, $secret_key, $firstname,$lastname,$city_id,$client);
        HelperApp::add_cookie('secret_key', $secret_key, $is_session);
        $this->redirect(Yii::app()->request->baseUrl . "/home/");
    }
    
    
    
    public function actionSignin() {  
        Yii::app()->params['page'] = 'Login';
        $this->render('signin',$this->viewData);  
    }  
    
    public function actionNewpassword() {  
        Yii::app()->params['page'] = 'New Password';
        $this->render('new-password',$this->viewData);  
    }
    
    public function actionRecoverypassword() {  
        Yii::app()->params['page'] = 'Recovery Password';
        $this->render('recovery-password',$this->viewData);  
    }  
    
    public function actionAccount($type = "setting", $p = 1, $id=""){
        
        $this->layout = 'account';
        switch ($type) {
            case "setting":
                $this->account_setting($type);
                break;
            case "manage_event":
                $this->manage_event($type);
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

        if ($_POST)
            $this->do_account_setting();
        
        
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = 'Account Setting';
        Yii::app()->params['is_tab'] = 'setting';
        $this->render('account-setting', $this->viewData);
    }
    
    private function do_account_setting() {
        $this->redirect(HelperUrl::baseUrl() . "user/account/type/setting/?s=1");
    }
    
    private function manage_event($type) {

        if ($_POST)
            $this->do_manage_event();
        
        
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = 'Management Event';
        Yii::app()->params['is_tab'] = 'manage_event';
        $this->render('manage_event', $this->viewData);
    }
    
    private function do_manage_event() {
        $this->redirect(HelperUrl::baseUrl() . "user/account/type/manage_event/?s=1");
    }
    
    
    private function paid_event($type) {

        if ($_POST)
            $this->do_paid_event();
        
        
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = "Management Paid Event's ticket";
        Yii::app()->params['is_tab']= 'paid_event';
        $this->render('paid_event', $this->viewData);
    }
    
    private function do_paid_event() {
        $this->redirect(HelperUrl::baseUrl() . "user/account/type/paid_event/?s=1");
    }
    
    private function change_password($type) {
        if ($_POST)
            $this->do_change_password();
        $this->viewData['message'] = $this->message;
        $this->viewData['type'] = $type;
        Yii::app()->params['page'] = "Change Password";
        Yii::app()->params['is_tab']= 'change_password';
        $this->render('change-password', $this->viewData);
    }
    
    private function do_change_password() {
        $this->redirect(HelperUrl::baseUrl() . "user/account/type/change_password/?s=1");
    }
    
    public function actionMake_profile() {

        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = "Make Profile";
        $this->render('make-profile', $this->viewData);
    }
    
    public function actionView_profile($s='current') {

        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = "My Profile";
        $this->render('view-profile', $this->viewData);
    }
}