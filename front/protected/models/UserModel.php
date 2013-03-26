<?php

class UserModel extends CFormModel {

    public function __construct() {
        
    }

    public function add($email, $password, $secret_key, $firstname,$lastname,$country_id,$client='customer',$signup_facebook) {
        $time = time();
        $sql = "INSERT INTO etk_users(email,password,secret_key,firstname,lastname,country_id,role,date_added,signup_facebook) VALUES(:email,:password,:secret_key,:firstname,:lastname,:country_id,:role,:date_added,:signup_facebook)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":email", $email);
        $command->bindParam(":password", $password);
        $command->bindParam(":secret_key", $secret_key);
        $command->bindParam(":firstname", $firstname);
        $command->bindParam(":lastname", $lastname);
        $command->bindParam(":country_id", $country_id);
        $command->bindParam(":role", $client);
        $command->bindParam(":date_added", $time);
        $command->bindParam(":signup_facebook", $signup_facebook);
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
        $sql = "SELECT eu.* , eo.title as organizer_title, eo.description as organizer_description, eo.thumbnail as organizer_thumbnail
                FROM etk_users eu
                LEFT JOIN etk_organizers eo
                ON eo.user_id = eu.id
                WHERE eu.id = :id
                AND eu.disabled = 0
                AND eu.banned = 0";
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

    
    public function get_metas($user_id) {
        $sql = "SELECT *
                FROM etk_user_metas
                WHERE user_id = :user_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        return $this->_parse_metas($command->queryAll());
    }

    private function _parse_metas($metas) {
        $tmp_metas = array();
        foreach ($metas as $k => $v) {
            $tmp_metas[$v['meta_key']] = $v['meta_value'];
        }
        return $tmp_metas;
    }

    public function update_metas($meta_key, $meta_value, $user_id) {
        $meta = $this->get_meta($meta_key, $user_id);
        if (!$meta)
            return $this->add_meta($meta_key, $meta_value, $user_id);

        $sql = "UPDATE etk_user_metas
                SET meta_value = :meta_value
                WHERE id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_value", $meta_value);
        $command->bindParam(":id", $meta['id'], PDO::PARAM_INT);
        return $command->execute();
    }

    public function get_meta($meta_key, $user_id) {
        $sql = "SELECT *
                FROM etk_user_metas
                WHERE meta_key = :meta_key
                AND user_id = :user_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_key", $meta_key);
        $command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function add_meta($meta_key, $meta_value, $user_id) {
        $sql = "INSERT INTO etk_user_metas(meta_key,meta_value,user_id) VALUES(:meta_key,:meta_value,:user_id)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_key", $meta_key);
        $command->bindParam(":meta_value", $meta_value);
        $command->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
}