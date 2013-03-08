<?php

class UserModel extends CFormModel {

    public function __construct() {
        
    }

    public function add($email, $password, $secret_key, $fullname) {
        $time = time();
        $sql = "INSERT INTO etk_users(email,password,secret_key,fullname,date_added) VALUES(:email,:password,:secret_key,:fullname,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":email", $email);
        $command->bindParam(":password", $password);
        $command->bindParam(":secret_key", $secret_key);
        $command->bindParam(":fullname", $fullname);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    public function is_existed_email($email) {
        $sql = "SELECT count(*) as total
                FROM etk_users
                WHERE email = :email
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":email", $email, PDO::PARAM_INT);
        $count = $command->queryRow();
        return $count['total'];
    }

    public function get($id) {
        $sql = "SELECT *
                FROM etk_users
                WHERE id = :id
                AND disabled = 0
                AND banned = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function get_by_api($apikey) {
        $sql = "SELECT *
                FROM etk_users
                WHERE apikey = :apikey
                AND disabled = 0
                AND banned = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":apikey", $apikey);
        return $command->queryRow();
    }
    
    public function get_by_email($email) {
        $sql = "SELECT *
                FROM etk_users
                WHERE email = :email
                AND disabled = 0
                AND banned = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":email", $email, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function get_by_secret_key($secret_key) {
        $sql = "SELECT *
                FROM etk_users
                WHERE secret_key = :secret_key
                AND disabled = 0
                AND banned = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":secret_key", $secret_key, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_users set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

    public function add_token($token, $user_id, $token_type, $date_added, $date_expired) {
        $sql = "INSERT INTO etk_tokens(token,user_id,token_type,date_added,date_expired) VALUES(:token,:user_id,:token_type,:date_added,:date_expired)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":token", $token);
        $command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $command->bindParam(":token_type", $token_type);
        $command->bindParam(":date_added", $date_added);
        $command->bindParam(":date_expired", $date_expired);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
    
    public function update_token($id){
        $sql = "UPDATE etk_tokens SET completed = 1 WHERE id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id,PDO::PARAM_INT);
        return $command->execute();
        
    }

    public function get_token($token) {
        $sql = "SELECT *
                FROM etk_tokens
                WHERE completed = 0
                AND date_expired > UNIX_TIMESTAMP()
                AND token = :token";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":token", $token);
        return $command->queryRow();
    }

}