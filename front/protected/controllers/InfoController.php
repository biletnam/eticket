<?php

class InfoController extends Controller {

    public function actions() {
        
    }

    public function actionIndex() {
    }
    
    public function action404(){
        $this->render('404');
    }
    
    public function actionView($page=''){
        $this->render($page);
    }

}