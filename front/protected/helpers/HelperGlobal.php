<?php

class HelperGlobal {    
    
    public static $log_description = '';
    
    public function __construct() {
        
    }
    
    public static function require_login() {
        
        if (!UserControl::LoggedIn()) {
            header("location:" . HelperUrl::baseUrl() . "admin/login/");
            die;
        }
    }
    
    public static function AccessControl($controller,$method){
        
        if(self::is_access($controller,$method))
            return true;
        header("location:". HelperUrl::baseUrl()."home/access_denied/");
    }

    private static function is_access($controller,$method) {
        
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
            'admin'=>array('home'=>array('index'),
                           'category'=>array('index'))
            );
        return $role[$role_name];
    }
    
    public static function add_log($admin_id,$controller,$method,$description = ""){
        $LogModel = new LogModel();        
        $LogModel->add($admin_id, $controller, $method, Yii::app()->request->userHostAddress,  serialize($description));
    }

}

