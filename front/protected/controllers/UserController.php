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
    
    public function actionRegister() {  

        $this->render('register',$this->viewData);
        
    }  
    
}