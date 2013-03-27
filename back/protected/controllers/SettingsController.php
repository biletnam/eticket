<?php

class SettingsController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $SettingsModel;

    public function init() {
        
        parent::init();
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $SettingsModel SettingsModel */
        $this->SettingsModel = new SettingsModel();
    }

    public function actions() {
        
    }
    
   

    public function actionIndex() {
        
        $this->CheckPermission();
        
        $settings = $this->SettingsModel->gets();
        
        if($_POST)
            $this->do_settings($settings);
        
        $this->viewData['message'] = $this->message;
        $this->viewData['settings'] = $settings;
        $this->render('index', $this->viewData);
        
    }
    
    public function do_settings($settings){
        foreach($settings as $s){
            $this->SettingsModel->update(array('option_value'=>$_POST[$s['option_key']],'id' => $s['id']));
        }
        $this->redirect(HelperUrl::baseUrl() . "settings/?s=1");
    }


}