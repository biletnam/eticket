<?php

class HelperGlobal {

    public static $log_description = '';
    private static $api_token = "4d50a7f525245db890218329b518f0edc0d7f8f7";

    public function __construct() {
        
    }

    public static function require_login($return_url = false) {

        if (!UserControl::LoggedIn()) {
            header("location:" . Yii::app()->request->baseUrl . "/user/signin/");
            die;
        }
    }

    public static function CheckAccessToken($need_login = false) {
        $UserModel = new UserModel();
        $AuthTokenModel = new AuthTokenModel();
        $api_token = isset($_GET['api_token']) ? $_GET['api_token'] : "";
        $access_token = isset($_GET['access_token']) ? $_GET['access_token'] : "";
        $code = "200";
        if ($api_token != self::$api_token) {
            $code = "2";
            $error = Helper::_error_code($code);
            HelperGlobal::return_data(array(), array('code' => $code, 'message' => array($error)));
        }

        if ($need_login && !$AuthTokenModel->get_by_token($access_token)) {
            $code = "3";
            $error = Helper::_error_code($code);
            HelperGlobal::return_data(array(), array('code' => $code, 'message' => array($error)));
        }

        return true;
    }

    public static function return_data($data = array(), $error = array()) {
        echo json_encode(array(
            'data' => $data,
            'error' => $error
        ));
        die;
    }
    
    public static function user_info($user){
        return array(
            'id'=>$user['id'],
            'email'=>$user['email'],
            'fullname'=>$user['fullname'],
            'img'=>$user['img'],
            'thumbnail'=>$user['thumbnail'],
            'date_added'=>$user['date_added'],
            'last_modified'=>$user['last_modified'],
            'apikey'=>$user['apikey']
        );
    }

    public static function AccessControl($controller, $method) {

        if (self::is_access($controller, $method))
            return true;
        header("location:" . Yii::app()->request->baseUrl . "/home/access_denied/");
    }

    private static function is_access($controller, $method) {

        self::require_login();

        // uncomment this line to add log when access to any method
        //self::add_log(UserControl::getId(),$controller, $method,array('Hành động'=>'Truy cập','Dữ liệu'=>  self::$log_description));

        $role_name = UserControl::getRole();
        $group = array('superadmin', 'admin', 'mod');

        //check group user has valid
        if (in_array($role_name, $group) === false)
            return false;

        //if role is admin then has all permission, continue otherwise
        if ($role_name == "superadmin")
            return true;

        //get role details of user
        $roles = self::role($role_name);

        //check user can access the controller, continue if true, return false otherwise
        if (!array_key_exists($controller, $roles))
            return false;

        //get the access methods of user
        $access_methods = $roles[$controller];

        //if user has all permission of that controller then return true, continue otherwise
        if ($access_methods == "all")
            return true;

        //if user can access the method then return true, false otherwise
        if (in_array($method, $access_methods) !== false)
            return true;
        return false;
    }

    private static function role($role_name) {
        $role = array(
            'superadmin' => 'all',
            'admin' => array('home' => array('index'),
                'category' => array('index'))
        );
        return $role[$role_name];
    }

    public static function add_log($admin_id, $controller, $method, $description = "") {
        $LogModel = new LogModel();
        $LogModel->add($admin_id, $controller, $method, Yii::app()->request->userHostAddress, serialize($description));
    }

}

