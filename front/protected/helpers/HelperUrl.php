<?php

class HelperUrl {
    
    public static function baseUrl($absolute = false){
        return Yii::app()->getBaseUrl($absolute)."/";
    }
    
    public static function hostInfo(){
        return Yii::app()->getHomeUrl();        
    }
    
    public static function upload_dir(){
        return Yii::app()->params['upload_dir'];
    }
    
    public static function upload_url(){
        return Yii::app()->params['upload_url'];
    }
}