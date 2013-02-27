<?php

class FaqController extends Controller {

    private $FaqModel;
    private $CategoryModel;
    private $viewData;
    private $message = array('success'=>true,'error'=>array());
    private $validator;
    public function init() {
        /* @var $FaqModel FaqModel */
        $this->FaqModel = new FaqModel();
        
        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();
        
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();
    }
    
    /**
     * Declares class-based actions.
     */
    public function actions() {
        
    }
    
    public function actionIndex($p = 1){
        $this->CheckPermission();
        
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        $args = array('s' => $s, 'deleted' => 0);

        $faqs = $this->FaqModel->gets($args, $p, $ppp);
        $total_faq = $this->FaqModel->counts($args);
        
        $this->viewData['faqs'] = $faqs;
        $this->viewData['total'] = $total_faq;        
        $this->viewData['paging'] = $total_faq > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/faq/index/p/", $total_faq, $p) : "";
        
        $this->render('index', $this->viewData);
    }
    
    public function actionAdd(){
        if($_POST)
            $this->do_add ();
        $this->viewData['categories'] = $this->CategoryModel->gets(array('deleted'=>0,'type'=>'faq'),1,200);
        $this->viewData['message'] = $this->message;
        $this->render('add',$this->viewData);
    }
    
    private function do_add(){
        $title = trim($_POST['title']);
        $category_id = $_POST['category'];
        $description = trim($_POST['description']);
        
        if($this->validator->is_empty_string($title))
            $this->message['error'][] = "Tiêu đề không được để trống.";
        if($this->validator->is_empty_string($description))
            $this->message['error'][] = "Nội dung không được để trống.";
        
        if(count($this->message['error']) > 0)
        {
            $this->message['success'] = false;
            return false;
        }
        
        $id = $this->FaqModel->add($category_id, $title, Helper::create_slug($title), $description,$_POST['disabled']);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Thêm', 'Dữ liệu' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl."/faq/edit/id/$id?s=1");
    }
    
    public function actionEdit($id = "") {
        $this->CheckPermission();
        $faq = $this->FaqModel->get($id);
        if (!$faq)
            $this->load_404 ();
        if ($_POST)
            $this->do_edit($faq);

        $this->viewData['message'] = $this->message;
        $this->viewData['faq'] = $faq;
        $this->viewData['categories'] = $this->CategoryModel->gets(array('deleted'=>0,'type'=>'faq'),1,200);
        $this->render('edit', $this->viewData);
    }

    private function do_edit($faq) {
        $title = trim($_POST['title']);
        $category_id = $_POST['category'];
        $description = trim($_POST['description']);
        
        if($this->validator->is_empty_string($title))
            $this->message['error'][] = "Tiêu đề không được để trống.";
        if($this->validator->is_empty_string($description))
            $this->message['error'][] = "Nội dung không được để trống.";
        
        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }
        
       

        $this->FaqModel->update(array('title'=>$title,'category_id'=>$category_id,'description'=>$description,'disabled'=>$_POST['disabled'],'deleted'=>$_POST['deleted'],'id'=>$faq['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Sửa', 'Dữ liệu cũ' => $faq, 'Dữ liệu mới' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/faq/edit/id/$faq[id]/?s=1");
    }
    
    public function actionDelete($id) {
        $this->CheckPermission();
        $faq = $this->FaqModel->get($id);
        if (!$faq)
            return;
        
        $this->FaqModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Xóa', 'Dữ liệu' => array('id' => $id)));
    }
}