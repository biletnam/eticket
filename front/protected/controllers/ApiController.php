<?php

class ApiController extends Controller {
    
    private $message = array('success'=>true,'error'=>array());
    private $validator;
    private $viewData;
    private $UserModel;
    private $AuthTokenModel;
    
    
    public function init(){
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();
        
        /* @var $UserModel UserModel */
        $this->UserModel = new UserModel();
        
        /* @var $AuthTokenModel AuthTokenModel */
        $this->AuthTokenModel = new AuthTokenModel();
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
        $os_version = trim($_POST['os_version']);
        $os_name = trim($_POST['os_name']);
        $device_name = trim($_POST['device_name']);
        
        if($this->validator->is_empty_string($email))
            $this->message['error'][] = "Email cannot be blank.";
        if(!$this->validator->is_email($email))
            $this->message['error'][] = "Email does not correct format.";
        if($this->validator->is_empty_string($password))
            $this->message['error'][] = "Password cannot be blank.";
        
        if(count($this->message['error']) > 0){            
            HelperGlobal::return_data(array(),array('code'=>4,'message'=>$this->message['error']));
        }
        
        $user = $this->UserModel->get_by_email($email);
        if(!$user)
        {
            $this->message['error'][] = "Email or Password does not correct.";
            HelperGlobal::return_data(array(),array('code'=>4,'message'=>$this->message['error']));
        }
        
        $hasher = new PasswordHash(10,TRUE);
        if(!$hasher->CheckPassword($password, $user['password']))
        {
            $this->message['error'][] = "Email or Password does not correct.";
            HelperGlobal::return_data(array(),array('code'=>4,'message'=>$this->message['error']));
        }
        $token = Helper::gen_access_token();
        $this->AuthTokenModel->add($user['id'], $token, $os_version, $os_name, $device_name);
        HelperGlobal::return_data(array('access_token'=>$token,'user'=>  HelperGlobal::user_info($user)),array('code'=>200,'message'=>$this->message['error']));
    }

    
}