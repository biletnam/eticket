<?php

class CategoryController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $CategoryModel;

    public function init() {

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();
    }

    public function actions() {
        
    }
    
   

    public function actionIndex($type ='all',$p = 1) {
        

        
        $this->CheckPermission();
        
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        
        $args = array('s' => $s, 'deleted' => 0);
        if($type != "all")
            $args['role'] = $type;

        $categories = $this->CategoryModel->gets($args, $p, $ppp);
        $total_category = $this->CategoryModel->counts($args);
        
        $this->viewData['categories'] = $categories;
        $this->viewData['total'] = $total_category;
        $this->viewData['paging'] = $total_category > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/category/index/type/$type/p/", $total_category, $p) : "";
        $this->viewData['type'] = $type;
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
        $file = $_FILES['file'];
        $type = $_POST['type'];
        $description = trim($_POST['description']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter category title.";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }
        $img = "";
        $thumbnail = "";

        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_category_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        $category_id = $this->CategoryModel->add($title, Helper::create_slug($title),$type,$img,$thumbnail,$description,$_POST['disabled']);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/category/edit/id/$category_id/?s=1");
    }

    public function actionEdit($id = "") {
        $this->CheckPermission();
        $category = $this->CategoryModel->get($id);
        if (!$category)
            $this->load_404 ();
        if ($_POST)
            $this->do_edit($category);

        $this->viewData['message'] = $this->message;
        $this->viewData['category'] = $category;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($category) {
        $title = trim($_POST['title']);
        $file = $_FILES['file'];
        $type = $_POST['type'];
        $description = trim($_POST['description']);
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter category title.";
        
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension";

        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";
        
        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }
        
        $img = $category['img'];
        $thumbnail = $category['thumbnail'];

        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_category_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        $this->CategoryModel->update(array('title' => $title,'type'=>$type, 'disabled' => $_POST['disabled'], 'deleted' => $_POST['deleted'], 'last_modified' => time(),'img'=>$img,'thumbnail'=>$thumbnail,'description'=>$description,'featured'=>$_POST['featured'],'id' => $category['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $category, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/category/edit/id/$category[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $category = $this->CategoryModel->get($id);
        if (!$category)
            return;

        $this->CategoryModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Deleted', 'Data' => array('id' => $id)));
    }

}