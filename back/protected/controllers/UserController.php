<?php

class UserController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $UserModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();
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
    public function actionIndex($p = 1) {
        $this->CheckPermission();
        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";
        $args = array('s' => $s);

        $users = $this->UserModel->gets($args, $p, $ppp);
        $total = $this->UserModel->counts($args);

        $this->viewData['users'] = $users;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/user/index/p/", $total, $p) : "";

        $this->render('index', $this->viewData);
    }
    
    public function actionBan($id){
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if(!$user)
            return;
        
        $this->UserModel->update(array('id'=>$id,'banned'=>1));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Banned người dùng', 'id' => $id));
        echo json_encode($this->message);
    }
    
    public function actionUnban($id){
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if(!$user)
            return;
        
        $this->UserModel->update(array('id'=>$id,'banned'=>0));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Unbanned người dùng', 'id' => $id));
        echo json_encode($this->message);
    }
    
    public function actionEdit($id){
        $this->CheckPermission();
        $user = $this->UserModel->get($id);
        if(!$user)
            $this->load_404 ();
        if($_POST)
            $this->do_edit($user);
        $this->viewData['user'] = $user;
        $this->viewData['message'] = $this->message;
        $this->render('edit',$this->viewData);
    }
    
   private function do_edit($user){
       $fullname = trim($_POST['fullname']);
       $day = $_POST['day'];
       $month = $_POST['month'];
       $year = $_POST['year'];
       $gender = isset($_POST['gender']) ? trim($_POST['gender']): null;       
       $birthday = $user['birthday'];
       
       if($this->validator->is_empty_string($fullname))
           $this->message['error'][] = "Họ tên không được để trống.";
       if(($day || $month || $year ) && !$this->validator->is_valid_date($day, $month, $year))
           $this->message['error'][] = "Ngày sinh không chính xác.";
       
       if(count($this->message['error']) > 0){
           $this->message['success'] = false;
           return false;
       }
       
       if($day && $month && $year)
           $birthday = "$year-$month-$day";
       
       $this->UserModel->update(array('id'=>$user['id'],
                                      'fullname'=>$fullname,
                                      'home_phone'=>trim($_POST['home_phone']),
                                      'cell_phone'=>trim($_POST['cell_phone']),
                                      'gender'=>$gender,
                                      'birthday'=>$birthday,
                                      'paypal_account'=>trim($_POST['paypal_account']),
                                      'banned'=>$_POST['banned']
                                      ));
       HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Hành động' => 'Sửa', 'Dữ liệu cũ' => $user,'Dữ liệu mới'=>$_POST));
       $this->redirect(Yii::app()->request->baseUrl."/user/edit/id/$user[id]?s=1");
       
   }
    
}