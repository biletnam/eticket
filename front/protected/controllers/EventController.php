<?php

class EventController extends Controller {
    
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
    
    
    public function actionCreate() {  
        //HelperGlobal::require_login();
        
        Yii::app()->params['page'] = 'Create Event';
        $this->render('create',$this->viewData);  
    }  
    
    public function actionEdit() {  
        //HelperGlobal::require_login();
        
        Yii::app()->params['page'] = '';
        $this->render('edit',$this->viewData);  
    } 
    
    public function actionInfo() {  
        //HelperGlobal::require_login();
        
        Yii::app()->params['page'] = 'Event Detail';
        $this->render('event',$this->viewData);  
    }  
    
    public function actionRegister_to_event() {  
        //HelperGlobal::require_login();
        
        Yii::app()->params['page'] = 'Payment Ticket';
        $this->render('payment_ticket',$this->viewData);  
    }  
    
    
}