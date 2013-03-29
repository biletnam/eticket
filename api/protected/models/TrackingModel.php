<?php

class TrackingModel extends CFormModel {

    public function __construct() {
        
    }
    
    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();

        

        if (isset($args['user_id'])) {
            $custom.= " AND et.user_id = :user_id";
            $params[] = array('name' => ':user_id', 'value' => $args['user_id'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['completed'])) {
            $custom.= " AND et.completed = :completed";
            $params[] = array('name' => ':completed', 'value' => $args['completed'], 'type' => PDO::PARAM_INT);
        }
        
        if (isset($args['ref_type'])) {
            $custom.= " AND et.ref_type = :ref_type";
            $params[] = array('name' => ':ref_type', 'value' => $args['ref_type'], 'type' => PDO::PARAM_STR);
        }
        
        if (isset($args['payment_type'])) {
            $custom.= " AND et.payment_type = :payment_type";
            $params[] = array('name' => ':payment_type', 'value' => $args['payment_type'], 'type' => PDO::PARAM_STR);
        }

        $sql = "SELECT et.*
                FROM etk_trackings et
                WHERE 1
                $custom
                ORDER BY et.date_added DESC
                LIMIT :page,:ppp";

        
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":page", $page, PDO::PARAM_INT);
        $command->bindParam(":ppp", $ppp, PDO::PARAM_INT);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);


        return $command->queryAll();
    }

    public function counts($args) {

        $custom = "";
        $params = array();

        if (isset($args['user_id'])) {
            $custom.= " AND et.user_id = :user_id";
            $params[] = array('name' => ':user_id', 'value' => $args['user_id'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['completed'])) {
            $custom.= " AND et.completed = :completed";
            $params[] = array('name' => ':completed', 'value' => $args['completed'], 'type' => PDO::PARAM_INT);
        }
        
        if (isset($args['ref_type'])) {
            $custom.= " AND et.ref_type = :ref_type";
            $params[] = array('name' => ':ref_type', 'value' => $args['ref_type'], 'type' => PDO::PARAM_STR);
        }
        
        if (isset($args['payment_type'])) {
            $custom.= " AND et.payment_type = :payment_type";
            $params[] = array('name' => ':payment_type', 'value' => $args['payment_type'], 'type' => PDO::PARAM_STR);
        }

        $sql = "SELECT count(*) as total
                FROM etk_trackings et
                WHERE 1
                $custom
                ";
        
        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);

        $count = $command->queryRow();
        return $count['total'];
    }

    public function add($payment_type, $payment_to, $currency, $user_id,$amount,$ref_type) {
        $time = time();
        $sql = "INSERT INTO etk_trackings(payment_type,payment_to,currency,user_id,ref_type,amount,date_added) VALUES(:payment_type,:payment_to,:currency,:user_id,:ref_type,:amount,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":payment_type", $payment_type);
        $command->bindParam(":payment_to", $payment_to);
        $command->bindParam(":currency", $currency);
        $command->bindParam(":user_id", $user_id);
        $command->bindParam(":ref_type", $ref_type);
        $command->bindParam(":amount", $amount);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    public function get($id) {
        $sql = "SELECT *
                FROM etk_trackings
                WHERE id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id);
        return $command->queryRow();
    }

    public function get_by_txn_id($txn_id) {
        $sql = "SELECT *
                FROM etk_trackings
                WHERE txn_id = :txn_id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":txn_id", $txn_id);
        return $command->queryRow();
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_trackings set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }
    
    public function get_metas($tracking_id) {
        $sql = "SELECT *
                FROM etk_tracking_metas
                WHERE tracking_id = :tracking_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":tracking_id", $tracking_id, PDO::PARAM_INT);
        return $this->_parse_metas($command->queryAll());
    }

    private function _parse_metas($metas) {
        $tmp_metas = array();
        foreach ($metas as $k => $v) {
            $tmp_metas[$v['meta_key']] = $v['meta_value'];
        }
        return $tmp_metas;
    }

    public function update_metas($meta_key, $meta_value, $tracking_id) {
        $meta = $this->get_meta($meta_key, $tracking_id);
        if (!$meta)
            return $this->add_meta($meta_key, $meta_value, $tracking_id);

        $sql = "UPDATE etk_tracking_metas
                SET meta_value = :meta_value
                WHERE id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_value", $meta_value);
        $command->bindParam(":id", $meta['id'], PDO::PARAM_INT);
        return $command->execute();
    }

    public function get_meta($meta_key, $tracking_id) {
        $sql = "SELECT *
                FROM etk_tracking_metas
                WHERE meta_key = :meta_key
                AND tracking_id = :tracking_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_key", $meta_key);
        $command->bindParam(":tracking_id", $tracking_id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function add_meta($meta_key, $meta_value, $tracking_id) {
        $sql = "INSERT INTO etk_tracking_metas(meta_key,meta_value,tracking_id) VALUES(:meta_key,:meta_value,:tracking_id)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_key", $meta_key);
        $command->bindParam(":meta_value", $meta_value);
        $command->bindParam(":tracking_id", $tracking_id, PDO::PARAM_INT);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

}