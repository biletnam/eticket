<?php

class HomeController extends Controller {

    public function init() {
        
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
        $this->CheckPermission();        
        $this->render('index');
    }

    public function actionError() {
        HelperGlobal::require_login();
        $this->layout = "404";
        $this->render("error");
    }

    public function actionAccess_denied() {        
        HelperGlobal::require_login();
        $this->layout = "401";
        $this->render("error");
        
    }
    
    public function actionLanguage($lang = "vn"){
        
        $arr = array('en','vn');
        if(in_array($lang, $arr) !== false)
            HelperApp::add_cookie ('lang', $lang,true);
        else
            HelperApp::add_cookie ('lang', "vn",true);      
        
        $this->redirect(Yii::app()->request->baseUrl."/admin/login/");
        
    }
    
}