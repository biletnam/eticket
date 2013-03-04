<?php

class ApiController extends Controller {
    
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
    
    public function actionCode_access(){
        die;
        $str = "eTicket";
        $base = "2013";
        //echo base64_encode($base);
        echo sha1(sha1($str).$base);
        
        //for generate apikey of user
        $apikey = "dMxK3uFUh".Ultilities::base32UUID();
        echo sha1(base64_encode($apikey));
    }
    
    public function actionSignin() {
        HelperGlobal::CheckAccessToken();
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email không được để trống.";
        if(!$this->validator->is_email($email))
            $this->message['error'][] = "Email không đúng định dạng.";
        if($this->validator->is_empty_string($password))
            $this->message['error'][] = "Mật khẩu không được để trống.";
        
        if(count($this->message['error']) > 0){            
            HelperGlobal::return_data(array(),array('code'=>4,'message'=>$this->message['error']));
        }
        
        $user = $this->UserModel->get_by_email($email);
        if(!$user)
        {
            $this->message['error'][] = "Email hoặc mật khẩu không chính xác.";
            HelperGlobal::return_data(array(),array('code'=>4,'message'=>$this->message['error']));
        }
        
        $hasher = new PasswordHash(10,TRUE);
        if(!$hasher->CheckPassword($password, $user['password']))
        {
            $this->message['error'][] = "Email hoặc mật khẩu không chính xác.";
            HelperGlobal::return_data(array(),array('code'=>4,'message'=>$this->message['error']));
        }
        
        HelperGlobal::return_data(array('access_token'=>$user['apikey'],'user'=>  HelperGlobal::user_info($user)),array('code'=>200,'message'=>$this->message['error']));
    }
    
}