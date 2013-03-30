<?php

class SlidersController extends Controller {
    
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
        HelperGlobal::CheckAccessToken();
        $args = array('deleted' => 0,'post_type' => 'slider','disabled'=> 0);
        $tmp = array();
        $sliders = $this->SlideModel->gets($args, 1, 5);
        foreach($sliders as $k=>$v){
            $tmp[] = array(
                'title'=>$v['title'],
                'slug'=>$v['slug'],
                'img'=>$v['img'],
                'thumbnail'=> HelperApp::get_thumbnail($v['thumbnail'],'iphone')
            );
        }
        $this->viewData['sliders'] = $tmp;        
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));
    }   
    
}