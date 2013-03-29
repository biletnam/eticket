<?php

class FaqController extends Controller {

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
        $categories = $this->CategoryModel->gets(array('deleted' => 0,'disabled'=>0, 'type' => 'faq'));
        foreach ($categories as $k => $c)
            $categories[$k]['faqs'] = $this->FaqModel->get_by_category($c['id']);

        $this->viewData['categories'] = $categories;
        Yii::app()->params['page'] = 'Help';
        $this->render('index', $this->viewData);
    }

    public function actionView($s = "") {

        $faq = $this->FaqModel->get_by_slug($s);
        if (!$faq)
            $this->layout = "404";

        $this->viewData['faq'] = $faq;
        Yii::app()->params['page'] = 'Help';
        $this->render('view', $this->viewData);
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

    public function actionSearch($p = 1) {
        $q = isset($_GET['q']) ? $_GET['q'] : "";
        $q = strlen($q) < 2 ? "" : $q;

        if ($q == "") {
            $this->viewData['faqs'] = array();
            $this->viewData['total'] = 0;
            $this->viewData['paging'] = "";
            $this->render('result', $this->viewData);
            die;
        }

        $ppp = 10;
        $args = array('deleted' => 0, 's' => $q, 'description' => $q);
        $faqs = $this->FaqModel->gets($args, $p, $ppp);
        $total = $this->FaqModel->counts($args);

        Yii::app()->params['page'] = 'Help';
        $this->viewData['faqs'] = $faqs;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/faq/search/p/", $total, $p) : "";
        $this->render('result', $this->viewData);
    }

}