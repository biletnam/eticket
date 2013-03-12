<?php

class UserController extends Controller {
    
    private $viewData;
    private $message = array('success' => true, 'error' => array());
    
    public function init() {
        parent::init();
        
        /* @var $EventModel EventModel */
        //$this->EventModel = new EventModel();
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
        Yii::app()->params['page'] = 'Register';
        $this->render('signup',$this->viewData); 
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