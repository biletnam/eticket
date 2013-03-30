<?php

class CountriesController extends Controller {
    
    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $EventModel;
    private $SlideModel;
    private $CountryModel;
    
    public function init() {
        parent::init();
        
        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();
        
         /* @var $SlideModel SlideModel */
        $this->SlideModel = new SlideModel();
        
        /* @var $CountryModel CountryModel */
        $this->CountryModel = new CountryModel();
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
        HelperGlobal::CheckAccessToken();
        $this->viewData['countries'] = $this->CountryModel->gets_all_countries();
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));
    }   
    
}