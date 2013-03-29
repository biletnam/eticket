<?php

class AuthTokenModel extends CFormModel {

    public function __construct() {
        
    }

    public function add($user_id, $token, $os_version, $os_name,$device_name) {
        $time = time();
        $expire = $time + 3600;
        $sql = "INSERT INTO vsk_auth_tokens(user_id,token,os_version,os_name,device_name,date_added,date_expired) VALUES(:user_id,:token,:os_version,:os_name,:device_name,:date_added,:date_expired)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $user_id);
        $command->bindParam(":token", $token);
        $command->bindParam(":os_version", $os_version);
        $command->bindParam(":os_name", $os_name);
        $command->bindParam(":device_name", $device_name);
        $command->bindParam(":date_added", $time);
        $command->bindParam(":date_expired", $expire);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    public function get($id) {
        $sql = "SELECT *
                FROM vsk_auth_tokens
                WHERE id = :id
                AND date_expired > UNIX_TIMESTAMP()
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function get_by_token($token) {
        $sql = "SELECT *
                FROM vsk_auth_tokens
                WHERE token = :token
                AND date_expired > UNIX_TIMESTAMP()";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":apikey", $token);
        return $command->queryRow();
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update vsk_auth_tokens set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

   
}