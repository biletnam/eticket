<?php

class HomeController extends Controller {
    
    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $EventModel;
    private $SlideModel;
    
    public function init() {
        parent::init();
        
        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();
        
         /* @var $SlideModel SlideModel */
        $this->SlideModel = new SlideModel();
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
        //$events = $this->EventModel->gets(array('deleted' => 0, 'is_today' => 1, 'published' => 1), 1, 5);
        
        $args = array('deleted' => 0,'post_type' => 'slider','disabled'=> 0);

        $sliders = $this->SlideModel->gets($args, 1, 5);

        $events = $this->EventModel->gets(array('deleted' => 0, 'is_today' => 1, 'published' => 1,'disabled'=>0), 1, 12);
        $this->viewData['events'] = $events;
        $this->viewData['sliders'] = $sliders;
        $this->layout = 'home';
        $this->render('index',$this->viewData);
        
    }   
    
}