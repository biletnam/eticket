<?php

class PageController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $PageModel;
    private $EventModel;

    public function init() {
        parent::init();

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();

        /* @var $PageModel PageModel */
        $this->PageModel = new PageModel();
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
    public function actionIndex($s) {
        if ($s == '')
            $this->load_404();

        $page = $this->PageModel->get_by_slug($s);
        if (!$page)
            $this->load_404();

        switch ($s) {
            case 'about-us':
                $this->load_about_us($page, $s);
                break;
            case 'services':
                $this->load_services($page, $s);
                break;
            case 'e-ticket':
                $this->load_e_ticket($page, $s);
                break;
            case 'site-map':
                $this->load_sitemap($page, $s);
                break;
        }
    }

    private function load_about_us($page, $s) {
        Yii::app()->params['page'] = $page['title'];
        $this->viewData['page'] = $page;
        $this->render('page-template', $this->viewData);
    }

    private function load_services($page, $s) {
        Yii::app()->params['page'] = $page['title'];
        $this->viewData['page'] = $page;
        $this->render('page-template', $this->viewData);
    }

    private function load_e_ticket($page, $s) {
        Yii::app()->params['page'] = $page['title'];
        $this->viewData['page'] = $page;
        $this->render('page-template', $this->viewData);
    }

    private function load_sitemap($page, $s) {
        Yii::app()->params['page'] = $page['title'];
        $this->viewData['page'] = $page;
        $this->render('page-template', $this->viewData);
    }

    public function actionContact_us() {

        if ($_POST)
            $this->do_contact();

        $this->viewData['message'] = $this->message;
        Yii::app()->params['page'] = "Contact Us";
        $this->render('contact_us', $this->viewData);
    }

    private function do_contact() {
        $yourname = trim($_POST['yourname']);
        $email = trim($_POST['email']);
        $message = trim($_POST['message']);

        if ($this->validator->is_empty_string($yourname))
            $this->message['error'][] = "Please enter your name.";
        if ($this->validator->is_empty_string($email))
            $this->message['error'][] = "Please enter your email.";
        if (!$this->validator->is_email($email))
            $this->message['error'][] = "Email is not correct.";
        if ($this->validator->is_empty_string($message))
            $this->message['error'][] = "Please enter your message.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $to = "ntnhanbk@gmail.com";
        $subject = "360islandevents.com - New Message";    
        $from = $email;
        @HelperApp::email_contact($to, $subject, $yourname, $message, $from);

        $msg = "Email was sent to admin.";
        $this->redirect(HelperUrl::baseUrl() . "page/contact_us/?s=1&msg=$msg");
    }

    public function actionContact_us_ajax() {
        if ($_POST) {
            $yourname = trim($_POST['yourname']);
            $email = trim($_POST['email']);
            $message = trim($_POST['message']);

            if ($this->validator->is_empty_string($yourname)){
                $this->message['error'][] = "Please enter your name.";
                $this->message['yourname'] = 'error';
            }
            if ($this->validator->is_empty_string($email)){
                $this->message['error'][] = "Please enter your email.";
                $this->message['email'] = 'error';
            }
            if (!$this->validator->is_email($email)){
                $this->message['error'][] = "Email is not correct.";
                $this->message['email'] = 'error';
            }
            if ($this->validator->is_empty_string($message)){
                $this->message['error'][] = "Please enter your message.";
                $this->message['yourmessage'] = 'error';
            }

            if (count($this->message['error']) > 0) {
                $this->message['success'] = false;
                echo json_encode($this->message);
                die;
            }

            $to = "ntnhanbk@gmail.com";
            $subject = "360islandevents.com - New Message";
            $from = $email;
            @HelperApp::email_contact($to, $subject, $yourname, $message, $from);

            echo json_encode($this->message);
            die;
        }
    }
    
    public function actionHow_it_work(){
        Yii::app()->params['page'] = "How it work";
        $this->render('how_it_work');
    }
    
    public function actionEmail(){
        
        $this->layout = 'email';
        $this->render('email_template');
    }

}