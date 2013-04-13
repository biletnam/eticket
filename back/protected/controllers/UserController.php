<?php

class UserController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $UserModel;
    private $EmailModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();

        /* @var $EmailModel EmailModel */
        $this->EmailModel = new EmailModel();
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
    public function actionIndex($role = 'all', $p = 1) {
        $this->CheckPermission();
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";



        $args = array('s' => $s, 'deleted' => 0);

        if ($role != "all")
            $args['role'] = $role;

        $users = $this->UserModel->gets($args, $p, $ppp);
        $total = $this->UserModel->counts($args);



        $this->viewData['role'] = $role;
        $this->viewData['users'] = $users;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/user/index/p/", $total, $p) : "";

        $this->render('index', $this->viewData);
    }

//    public function actionClients($role = 'client', $p = 1) {
//        $this->CheckPermission();
//        $ppp = Yii::app()->getParams()->itemAt('ppp');
//        $s = isset($_GET['s']) ? $_GET['s'] : "";
//        $s = strlen($s) > 2 ? $s : "";
//
//
//
//        $args = array('s' => $s, 'deleted' => 0);
//        $args['role'] = $role;
//
//        $users = $this->UserModel->gets($args, $p, $ppp);
//        $total = $this->UserModel->counts($args);
//
//
//
//        $this->viewData['role'] = $role;
//        $this->viewData['users'] = $users;
//        $this->viewData['total'] = $total;
//        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/user/index/p/", $total, $p) : "";
//
//        $this->render('client', $this->viewData);
//    }
//    
//    public function actionCustomer($role = 'customer', $p = 1) {
//        $this->CheckPermission();
//        $ppp = Yii::app()->getParams()->itemAt('ppp');
//        $s = isset($_GET['s']) ? $_GET['s'] : "";
//        $s = strlen($s) > 2 ? $s : "";
//
//
//
//        $args = array('s' => $s, 'deleted' => 0);
//        $args['role'] = $role;
//
//        $users = $this->UserModel->gets($args, $p, $ppp);
//        $total = $this->UserModel->counts($args);
//
//
//
//        $this->viewData['role'] = $role;
//        $this->viewData['users'] = $users;
//        $this->viewData['total'] = $total;
//        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/user/index/p/", $total, $p) : "";
//
//        $this->render('customer', $this->viewData);
//    }

    public function actionBan($id) {
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if (!$user)
            return;

        $this->UserModel->update(array('id' => $id, 'banned' => 1));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Lock this user', 'id' => $id));
        echo json_encode($this->message);
    }

    public function actionUnban($id) {
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if (!$user)
            return;

        $this->UserModel->update(array('id' => $id, 'banned' => 0));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Unlock this user', 'id' => $id));
        echo json_encode($this->message);
    }

    public function actionEdit($id) {
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if (!$user)
            $this->load_404();
        if ($_POST)
            $this->do_edit($user);
        $this->viewData['user'] = $user;
        $this->viewData['message'] = $this->message;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($user) {
        $lastname = trim($_POST['lastname']);
        $firstname = trim($_POST['firstname']);
        $file = $_FILES['file'];

        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : null;


        if ($this->validator->is_empty_string($firstname))
            $this->message['error'][] = "Please enter first name.";
//        if (($day || $month || $year ) && !$this->validator->is_valid_date($day, $month, $year))
//            $this->message['error'][] = "Birth date does not correct.";



        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->check_min_image_size(300, 300, $file['tmp_name']))
            $this->message['error'][] = "Image's size does not correct.";

        if (count($this->message['error']) > 0) {
            $this->message['success'] = false;
            return false;
        }

//        if ($day && $month && $year)
//            $birthday = "$year-$month-$day";

        $img = $user['img'];
        $thumbnail = $user['thumbnail'];

        // check if has thumbnail
        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_avatar_sizes(), $user['img']);
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        $this->UserModel->update(array('id' => $user['id'],
            'firstname' => $firstname,
            'lastname' => $lastname,
            'home_phone' => trim($_POST['home_phone']),
            'cell_phone' => trim($_POST['cell_phone']),
            'gender' => $gender,
            'banned' => $_POST['banned'],
            'img' => $img,
            'thumbnail' => $thumbnail
        ));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $user, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/user/edit/id/$user[id]?s=1");
    }

    public function actionPending($p = 1) {
        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $args = array('s' => $s, 'deleted' => 0, 'role' => 'waiting');

        $users = $this->UserModel->gets($args, $p, $ppp);
        $total = $this->UserModel->counts($args);

        $this->viewData['users'] = $users;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, HelperUrl::baseUrl() . "user/pending/p/", $total, $p) : "";

        $this->render('pending', $this->viewData);
    }

    public function actionApproved($email, $id, $approve) {
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        $message = "";
        $subject = "";
        /*

          if ($approve == 'client') {
          $subject = 'Event Organizer Account Approved';
          $note = "Dear " . $userinfo['firstname'] . " " . $userinfo['lastname'] . "<br/><br/>
          Congratulations!<br/>
          Your request to become an Event Organizer has been approved. You may now create events and start selling tickets on our website http://www.360islandevents.com .<br/>
          If you get any problems please do not hesitate to contact us.<br/>
          Regards,<br/>
          The 360 Island Events Team";
          } else {
          $subject = 'Event Organizer Account Not Approved';
          $note = "Dear " . $userinfo['firstname'] . " " . $userinfo['lastname'] . "<br/><br/>
          We apologize but your request to be registered as an Event Organizer has been denied.<br/>
          If you feel that there has been some mistake you may contact us at sales@360islandevents.com.<br/>
          Regards,<br/>
          The 360 Island Events Team";
          }
         */

        if ($approve == 'client') {
            $email_template = $this->EmailModel->get_by_slug('organizer-approve');
            $subject = $email_template['title'];
            $message = $email_template['content'];
            $replace = array('$firstname', '$lastname', '$website_url');
            $data = array($user['firstname'], $user['lastname'], HelperUrl::hostInfo());
            $message = str_replace($replace, $data, $message);
        }
        else{
            $email_template = $this->EmailModel->get_by_slug('organizer-deny');
            $subject = $email_template['title'];
            $message = $email_template['content'];
            
            $replace = array('$firstname', '$lastname');
            $data = array($user['firstname'], $user['lastname']);
            $message = str_replace($replace, $data, $message);
        }

        @HelperApp::email($email, $subject, $message);

        $this->UserModel->update(array('role' => $approve, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Delete', 'Data' => array('id' => $id)));
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if (!$user)
            return;

        $this->UserModel->delete($id);
    }

}