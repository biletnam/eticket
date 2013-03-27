<?php

class SlideController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $SlideModel;

    public function init() {
        
        parent::init();
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $SlideModel SlideModel */
        $this->SlideModel = new SlideModel();
    }

    public function actions() {
        
    }
    
   

    public function actionIndex($p = 1) {
        
        $this->CheckPermission();
        
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        
        $args = array('s' => $s, 'deleted' => 0,'post_type' => 'slider');

        $sliders = $this->SlideModel->gets($args, $p, $ppp);
        $total_sliders = $this->SlideModel->counts($args);
        
        $this->viewData['sliders'] = $sliders;
        $this->viewData['total'] = $total_sliders;
        $this->viewData['paging'] = $total_sliders > $ppp ? HelperApp::get_paging($ppp, HelperUrl::baseUrl() . "slide/index/p/", $total_sliders, $p) : "";
        $this->render('index', $this->viewData);
        
    }

    public function actionAdd() {   
        
        $this->CheckPermission();
        if ($_POST)
            $this->do_add();

        $this->viewData['message'] = $this->message;
        $this->render('add', $this->viewData);
    }

    private function do_add() {
        $title = trim($_POST['title']);
        $content = $_POST['content'];
        $file = $_FILES['file'];
        
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Title cannot be blank.";
        
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "Image does not correct format or capacity.";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(1500, 350, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        
        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $img = "";
        $thumbnail = "";
        
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_slider_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }
        
        $post_type = 'slider';
        
        $slide_id = $this->SlideModel->add(UserControl::getId(),$title, Helper::create_slug($title),$content,$img,$thumbnail,$post_type);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->redirect(HelperUrl::baseUrl() . "slide/edit/id/$slide_id/?s=1");
    }

    public function actionEdit($id = "") {
        $this->CheckPermission();
        $slide = $this->SlideModel->get($id);
        if (!$slide)
            $this->load_404 ();
        if ($_POST)
            $this->do_edit($slide);

        $this->viewData['message'] = $this->message;
        $this->viewData['slide'] = $slide;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($slide) {
        $title = trim($_POST['title']);
        $content = $_POST['content'];

        $file = $_FILES['file'];

        
        //$test = $_FILES['test'];
        
        //var_dump($this->validator->is_valid_file($test));die;
        
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Title cannot be blank.";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "Image does not correct format or capacity.";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(1500, 350, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        
        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }
        
        
        $img = $slide['img'];
        $thumbnail = $slide['thumbnail'];

        
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_slider_sizes(),$img);
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }
        
        $this->SlideModel->update(array('title' => $title, 'deleted' => $_POST['deleted'],'disabled' => $_POST['disabled'], 'last_modified' => time(),'content'=>$content,'img'=>$img,'thumbnail'=>$thumbnail,'user_id'=>  UserControl::getId(),'id' => $slide['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old Data' => $slide, 'New Data' => $_POST));
        $this->redirect(HelperUrl::baseUrl() . "slide/edit/id/$slide[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $slide = $this->SlideModel->get($id);
        if (!$slide)
            return;

        $this->SlideModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Delete', 'Data' => array('id' => $id)));
    }

}