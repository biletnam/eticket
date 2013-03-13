<?php

class UserControl {

    private static $instance = null;
    private static $fetch = false;
    /**
     * @description Check if user is logged in by validate user cookie data
     * @return bool
     */
    public static function LoggedIn() {
        
        self::FetchUserInstance();

        if (is_null(self::$instance)){
            return false;
        } else {
            return true;
        }
    }

    private static function FetchUserInstance() {
        if(self::$fetch) return;        
        $secret_key = HelperApp::get_cookie('secret_key');
        if ($secret_key == null) {
            self::$fetch = true;            
            return false;
        } else {
            $UserModel = new UserModel();          
            self::$instance = $UserModel->get_by_secret_key($secret_key);
        }
        self::$fetch = true;
    }

    
    public static function getMember(){
        self::FetchUserInstance();
        return self::$instance;
    }
    
    public static function DoLogout() {
        HelperApp::clear_cookie();
    }
    
    public static function getId(){
        self::FetchUserInstance();
        return self::$instance['id'];
    }
    
    public static function getPassword(){
        self::FetchUserInstance();
        return self::$instance['password'];
    }
    
    public static function getEmail(){
        self::FetchUserInstance();
        return self::$instance['email'];
    }
    public static function getFirstname(){
        self::FetchUserInstance();
        return self::$instance['firstname'];
    }
    public static function getLastname(){
        self::FetchUserInstance();
        return self::$instance['lastname'];
    }
    
    public static function getRole(){
        self::FetchUserInstance();
        return self::$instance['role'];
    }
    
    public static function getSecretKey(){
        self::FetchUserInstance();
        return self::$instance['secret_key'];
    }
}