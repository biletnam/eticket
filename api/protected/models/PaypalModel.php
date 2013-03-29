<?php

class PaypalModel extends CFormModel {

    public function __construct() {
        
    }
    
    public function test($info){
        $sql = "INSERT INTO etk_test(info,date_added) VALUES(:info,NOW())";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":info", $info);
        $command->execute();
    }
    
    public function add($paypal_code,$tracking_id,$paypal_fee,$info){
        $time = time();
        $sql = "INSERT INTO etk_paypals(paypal_code,tracking_id,paypal_fee,info,date_added) VALUES(:paypal_code,:tracking_id,:paypal_fee,:info,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":paypal_code", $paypal_code);
        $command->bindParam(":tracking_id", $tracking_id,PDO::PARAM_INT);
        $command->bindParam(":paypal_fee", $paypal_fee);
        $command->bindParam(":info", $info);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
    
    public function get($id) {
        $sql = "SELECT *
                FROM etk_paypals
                WHERE id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id);
        return $command->queryRow();
    }
    
    
    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_paypals set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

}