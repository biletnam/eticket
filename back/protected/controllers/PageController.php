<?php

class PageController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $PageModel;

    public function init() {
        
        parent::init();
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $PageModel PageModel */
        $this->PageModel = new PageModel();
    }

    public function actions() {
        
    }
    
   

    public function actionIndex($p = 1) {
        
        $this->CheckPermission();
        
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        
        $args = array('s' => $s, 'deleted' => 0,'post_type' => 'page');

        $pages = $this->PageModel->gets($args, $p, $ppp);
        $total_pages = $this->PageModel->counts($args);
        
        $this->viewData['pages'] = $pages;
        $this->viewData['total'] = $total_pages;
        $this->viewData['paging'] = $total_pages > $ppp ? HelperApp::get_paging($ppp, HelperUrl::baseUrl() . "page/index/p/", $total_pages, $p) : "";
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

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(940, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        
        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $img = "";
        $thumbnail = "";
        
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_page_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }
        
        $post_type = 'page';
        
        $page_id = $this->PageModel->add(NULL,$title, Helper::create_slug($title),$content,$img,$thumbnail,$post_type);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->redirect(HelperUrl::baseUrl() . "page/edit/id/$page_id/?s=1");
    }

    public function actionEdit($id = "") {
        $this->CheckPermission();
        $page = $this->PageModel->get($id);
        if (!$page)
            $this->load_404 ();
        if ($_POST)
            $this->do_edit($page);

        $this->viewData['message'] = $this->message;
        $this->viewData['page'] = $page;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($page) {
        $title = trim($_POST['title']);
        $content = $_POST['content'];
        $file = $_FILES['file'];

        
        //$test = $_FILES['test'];
        
        //var_dump($this->validator->is_valid_file($test));die;
        
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Title cannot be blank.";

        
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "Image does not correct format or capacity.";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        
        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }
        
        
        $img = $page['img'];
        $thumbnail = $page['thumbnail'];

        
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_page_sizes(),$img);
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }
        
        $this->PageModel->update(array('title' => $title, 'deleted' => $_POST['deleted'],'disabled' => $_POST['disabled'], 'last_modified' => time(),'content'=>$content,'img'=>$img,'thumbnail'=>$thumbnail,'user_id'=>NULL,'id' => $page['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old Data' => $page, 'New Data' => $_POST));
        $this->redirect(HelperUrl::baseUrl() . "page/edit/id/$page[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $advertise = $this->PageModel->get($id);
        if (!$advertise)
            return;

        $this->PageModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Delete', 'Data' => array('id' => $id)));
    }

}