<?php

class LogController extends Controller {

    private $LogModel;
    private $viewData;
    
    public function init() {
        parent::init();
        /* @var $LogModel LogModel */
        $this->LogModel = new LogModel();
    }

    public function actions() {
        
    }
    
    public function actionIndex($p = 1){
        $this->CheckPermission();
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        
        $ppp = 100;
        $args = array('s'=>$s);
        
        $logs = $this->LogModel->gets($args,$p,$ppp);
        $total = $this->LogModel->counts($args);
        
        $this->viewData['logs'] = $logs;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl."/log/index/p/", $total, $p) : "";
        $this->render('index',$this->viewData);
    }
}