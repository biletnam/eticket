<?php

class FaqsController extends Controller {

    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $viewData;
    private $FaqModel;
    private $CategoryModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $FaqModel FaqModel */
        $this->FaqModel = new FaqModel();

        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();
    }

    public function actions() {
        
    }

    public function actionIndex() {
        HelperGlobal::CheckAccessToken();
        $categories = $this->CategoryModel->gets(array('deleted' => 0,'disabled'=>0, 'type' => 'faq'));
        foreach ($categories as $k => $c)
            $categories[$k]['faqs'] = $this->FaqModel->get_by_category($c['id']);

        $this->viewData['categories'] = $categories;
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));
    }

    public function actionView($s = "") {

        $faq = $this->FaqModel->get_by_slug($s);
        if (!$faq)
            HelperGlobal::return_data($this->viewData, array('code' => 404, 'message' => $this->message['error']));

        $this->viewData['faq'] = $faq;
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));
    }

    public function actionCategory($c = "", $p = 1) {
        $category = $this->CategoryModel->get_by_slug($c);
        if (!$category)
            $this->layout = "404";
        $ppp = 10;
        $faqs = $this->FaqModel->get_by_category($category['id'], $p, $ppp);
        $total = $this->FaqModel->count_by_category($category['id']);

        Yii::app()->params['page'] = 'Help';
        $this->viewData['category'] = $category;
        $this->viewData['faqs'] = $faqs;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/faq/category/c/$c/p/", $total, $p) : "";
        $this->render('category', $this->viewData);
    }

}