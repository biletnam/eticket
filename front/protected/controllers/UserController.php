<?php

class UserController extends Controller {
    
    private $message = array('success'=>true,'error'=>array());
    private $validator;
    private $viewData;
    private $UserModel;
    
    public function init(){
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();
        
        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();
    }
    
    public function actions() {
        
    }

    public function actionIndex() {
    }
    
    public function actionSignup() {
        
        if($_POST)
            $this->do_signup ();
        $this->viewData['message'] = $this->message;
        $this->render('signup',$this->viewData);
    }
    
    private function do_signup(){
        $pattern = '/^[A-Za-z0-9]+(?:[_][A-Za-z0-9]+)*$/';
        $special_char = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        $email = trim($_POST['email']);
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        $fullname = trim($_POST['fullname']);
        $is_session = isset($_POST['remember']) ? false : true;
        
        if($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email không được để trống.";
        if(!$this->validator->is_email($email))
            $this->message['error'][] = "Email không đúng định dạng.";
        if($this->UserModel->is_existed_email($email))
            $this->message['error'][] = "Email này đã có rồi.";
        if($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "Mật khẩu không được để trống.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Mật khẩu ít nhất 6, tối đa 20 ký tự.";
        if($pwd1 != $pwd2)
            $this->message['error'][] = "Mật khẩu và xác nhận mật khẩu phải giống nhau.";
        if ($this->validator->is_empty_string($fullname))
            $this->message['error'][] = "Họ và tên không được để trống.";
        if (preg_match($special_char, $fullname))
            $this->message['error'][] = "Họ và tên không bao gồm ký tự đặc biệt.";
        
        if(count($this->message['error']) > 0){
            $this->message['success'] = false;
            return false;
        }
        
        $hasher = new PasswordHash(10,TRUE);
        $password = $hasher->HashPassword($pwd1);
        $secret_key = Ultilities::base32UUID();
        
        $user_id = $this->UserModel->add($email, $password, $secret_key, $fullname);
        HelperApp::add_cookie('secret_key', $secret_key,$is_session);
        $this->redirect(Yii::app()->request->baseUrl."/home/");
        
    }
    
    public function actionSignin() {
        if($_POST)
            $this->do_signin ();
        $this->viewData['message'] = $this->message;
        
        $this->render('signin',$this->viewData);
    }
    
    private function do_signin(){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $is_session = isset($_POST['remember']) ? false : true;
        if($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email không được để trống.";
        if(!$this->validator->is_email($email))
            $this->message['error'][] = "Email không đúng định dạng.";
        if($this->validator->is_empty_string($password))
            $this->message['error'][] = "Mật khẩu không được để trống.";
        
        if(count($this->message['error']) > 0){
            $this->message['success'] = false;
            return false;
        }
        
        $user = $this->UserModel->get_by_email($email);
        if(!$user)
        {
            $this->message['error'][] = "Email hoặc mật khẩu không chính xác.";
            $this->message['success'] = false;
            return false;
        }
        
        $hasher = new PasswordHash(10,TRUE);
        if(!$hasher->CheckPassword($password, $user['password']))
        {
            $this->message['error'][] = "Email hoặc mật khẩu không chính xác.";
            $this->message['success'] = false;
            return false;
        }
        
        HelperApp::add_cookie('secret_key', $user['secret_key'],$is_session);
        $url = isset($_GET['return']) ? $_GET['return'] : Yii::app()->request->baseUrl."/home/";
        $this->redirect($url);
    }
    
    public function actionSignout() {
        UserControl::DoLogout();
        $this->redirect(Yii::app()->request->baseUrl."/home/");
    }
    
    public function actionForgot(){
        
        if($_POST)
            $this->do_forgot ();
        $this->viewData['message'] = $this->message;
        $this->render('forgot-password',$this->viewData);
    }
    
    private function do_forgot(){
        $email = trim($_POST['email']);
        $user = $this->UserModel->get_by_email($email);
        if($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email không được để trống";
        if(!$this->validator->is_email($email))
            $this->message['error'][] = "Email không đúng định dạng.";             
        if(!$user)
            $this->message['error'][] = "Email này không tồn tại.";
        
        if(count($this->message['error']) > 0){
            $this->message['success'] = false;
            return false;
        }
        
        $token = Ultilities::base32UUID();
        $date_added = time();
        $date_expired = $date_added + (Yii::app()->getParams()->itemAt('token_time')) * 86400;
        
        $this->UserModel->add_token($token, $user['id'], 'password', $date_added, $date_expired);
        $msg = "Please check your email. We just sent you an email with a link to setup your new password.";
        
        $forgot_url = Yii::app()->request->hostInfo.Yii::app()->request->baseUrl . "/user/reset/t/$token";
        $to = $email;
        $subject = "Yêu cầu lấy lại mật khẩu";
        $message = 'Xin chào <strong>' . $user['fullname'] . '</strong>, <br /><br />
                    Đã có yêu cầu lấy lại mật khẩu tại website VeSuKien.vn. 
                    Nếu đó là bạn, hãy nhấn vào đường dẫn bên dưới để tiếp tục.
                    Nếu không, hãy bỏ qua email này.<br/><br />
                    <a href="' . $forgot_url . '">' . $forgot_url . '</a><br/><br/>
        
                    Nếu bạn có bất kỳ thắc mắc nào, vui lòng liện hệ với chúng tôi theo địa chỉ 
                    email <a href="mailto:info@htmlfivemedia.com">info@htmlfivemedia.com</a> hoặc gọi <strong>0987.999.319</strong> để được tư vấn trực tuyến.<br /><br />
                    
                    Chúc bạn thành công!<br /><br />                    
                    ';

        HelperApp::email($to, $subject, $message);        
        $this->redirect(Yii::app()->request->baseUrl."/user/forgot/?s=1&msg=$msg");
        
    }
    
    public function actionReset($t = ""){
        if($this->validator->is_empty_string($t))
            $this->redirect (Yii::app()->request->baseUrl."/user/forgot/");
        
        $token = $this->UserModel->get_token($t);
        if(!$token)    
            $this->message['success'] = false;
        if($_POST)
            $this->do_reset ($token);
        $this->viewData['token'] = $token;
        $this->viewData['message'] = $this->message;
        $this->render('reset-password',$this->viewData);
    }
    
    private function do_reset($token){
        $pwd1 = trim($_POST['pwd1']);
        $pwd2 = trim($_POST['pwd2']);
        
        if($this->validator->is_empty_string($pwd1))
            $this->message['error'][] = "Mật khẩu không được để trống.";
        if (strlen($pwd1) < 6 || strlen($pwd1) > 20)
            $this->message['error'][] = "Mật khẩu ít nhất 6, tối đa 20 ký tự.";
        if($pwd1 != $pwd2)
            $this->message['error'][] = "Mật khẩu và xác nhận mật khẩu phải giống nhau.";
        
        if(count($this->message['error']) > 0){
            $this->message['success'] = false;
            return false;
        }
        $haser = new PasswordHash(10,true);
        $password = $haser->HashPassword($pwd1);
        
        $this->UserModel->update_token($token['id']);
        $this->UserModel->update(array('password'=>$password,'id'=>$token['user_id']));
        $this->redirect(Yii::app()->request->baseUrl."/user/signin/");
    }
    
    public function actionProfile() {
        $this->render('profile');
    }
}