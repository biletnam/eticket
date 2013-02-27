<?php

class AdminController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $AdminModel;

    public function init() {

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $AdminModel AdminModel */
        $this->AdminModel = new AdminModel();
    }

    public function actions() {
        
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($p = 1) {

        $this->CheckPermission();
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        $args = array('s' => $s);

        $admins = $this->AdminModel->gets($args, $p, $ppp);
        $total = $this->AdminModel->counts($args);

        $this->viewData['admins'] = $admins;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/admin/index/p/", $total, $p) : "";

        $this->render('index', $this->viewData);
    }

    public function actionLogout() {
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Thoát'));
        UserControl::DoLogout();
        $this->redirect(Yii::app()->request->baseUrl . "/admin/login/");
    }

    public function actionLogin() {
        if (UserControl::LoggedIn())
            $this->redirect(Yii::app()->request->baseUrl);
        $this->layout = "login";
        if ($_POST)
            $this->do_login();
        $this->viewData['message'] = $this->message;
        $this->render('login', $this->viewData);
    }

    private function do_login() {
        
        $title = trim($_POST['title']);
        $password = trim($_POST['password']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Tài khoản không được đễ trống.";
        if ($this->validator->is_empty_string($password))
            $this->message['error'][] = "Mật khẩu không được đễ trống.";
        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $admin = $this->AdminModel->get_by_title($title);
        
        
        
        if (!$admin) {
            $this->message['error'][] = "Tài khoản hoặc mật khẩu không chính xác.";
            $this->message['success'] = false;
            return false;
        }

        $hasher = new PasswordHash(10, true);
        if (!$hasher->CheckPassword($password, $admin['password'])) {
            $this->message['error'][] = "Tài khoản hoặc mật khẩu không chính xác.";
            $this->message['success'] = false;
            return false;
        }
        
        HelperApp::add_cookie('secret_key', $admin['secret_key'], true);
        //HelperApp::add_cookie('secret_key', $admin['secret_key'], false);
        HelperGlobal::add_log($admin['id'], $this->controllerID(), $this->methodID(), array('Hành động' => 'Đăng nhập'));        
        $this->redirect(Yii::app()->request->baseUrl . "/home/");
    }

    public function actionPassword() {

        HelperGlobal::require_login();

        if ($_POST)
            $this->do_password();
        $this->viewData['message'] = $this->message;
        $this->render('password', $this->viewData);
    }

    private function do_password() {
        $oldpwd = trim($_POST['oldpwd']);
        $newpwd1 = trim($_POST['newpwd1']);
        $newpwd2 = trim($_POST['newpwd2']);

        $hasher = new PasswordHash(10, TRUE);
        
        if ($this->validator->is_empty_string($oldpwd))
            $this->message['error'][] = "Mật khẩu cũ không được để trống.";
        if (!$hasher->CheckPassword($oldpwd, UserControl::getPassword()))
            $this->message['error'][] = "Mật khẩu cũ không chính xác.";
        if ($this->validator->is_empty_string($newpwd1))
            $this->message['error'][] = "Mật khẩu mới không được để trống.";
        if ($newpwd1 != $newpwd2)
            $this->message['error'][] = "Mật khẩu mới và xác nhận không giống nhau.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

        $password = $hasher->HashPassword($newpwd1);
        $this->AdminModel->update(array('password' => $password, 'id' => UserControl::getId()));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Đổi mật khẩu'));
        $this->redirect(Yii::app()->request->baseUrl . "/admin/password/?s=1");
    }
   

}