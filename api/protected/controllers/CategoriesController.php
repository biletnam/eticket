<?php

class CategoriesController extends Controller {
    
    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $EventModel;
    private $SlideModel;
    private $CategoryModel;
    
    public function init() {
        parent::init();
        
        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();
        
         /* @var $SlideModel SlideModel */
        $this->SlideModel = new SlideModel();
        
        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();
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
        $args = array('deleted' => 0,'type' => 'event','disabled'=> 0);
        $categories = $this->CategoryModel->gets($args,1,100);
        foreach($categories as $k=>$v){
            $categories[$k]['thumbnail'] = HelperApp::get_thumbnail($v['thumbnail'],'small');
        }
        $this->viewData['categories'] = $categories;
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));
    }   
    
    public function actionEvents($id = 0){
        HelperGlobal::CheckAccessToken();
        $category = $this->CategoryModel->get($id);
        
        if(!$category)
            HelperGlobal::return_data(array(), array('code' => 404, 'message' => Helper::_error_code(404)));        
        
        $events = $this->EventModel->gets(array('deleted' => 0, 'is_today' => 1, 'published' => 1,'disabled'=>0,'search_cate'=>$category['id']), 1, 12);
        foreach($events as $k=>$v){
            
            $events[$k]['thumbnail'] = HelperApp::get_thumbnail($events[$k]['thumbnail']);
        }
        $category['thumbnail'] = unserialize($category['thumbnail']);
        $this->viewData['events'] = $events;
        $this->viewData['category'] = $category;
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));        
    }
    
}