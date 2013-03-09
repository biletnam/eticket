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
    
    public function actionChangepassword() {  
        Yii::app()->params['page'] = 'Change Password';
        $this->render('change-password',$this->viewData);  
    }
    
    public function actionRecovery() {  
        Yii::app()->params['page'] = 'Recovery Password';
        $this->render('recovery-password',$this->viewData);  
    }  
    
}