<?php

class AdminModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom = " AND title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }
        
        $sql = "SELECT *
                FROM vsk_admins
                WHERE 1
                $custom
                ORDER BY title ASC
                LIMIT :page,:ppp";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":page", $page);
        $command->bindParam(":ppp", $ppp);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);
        
        return $command->queryAll();
    }

    public function counts($args) {
        
        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom = " AND title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }
        
        $sql = "SELECT count(*) as total
                FROM vsk_admins
                WHERE 1
                $custom
                ";
        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);
        
        $count = $command->queryRow();
        return $count['total'];
    }

    public function get($id) {
        $sql = "SELECT *
                FROM vsk_admins
                WHERE id = :id
                AND disabled = 0
                AND deleted = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id);
        return $command->queryRow();
    }

    public function get_by_secret_key($secret_key) {
        $sql = "SELECT *
                FROM vsk_admins
                WHERE secret_key = :secret_key
                AND disabled = 0
                AND deleted = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":secret_key", $secret_key);
        return $command->queryRow();
    }

    public function get_by_title($title) {
        $sql = "SELECT *
                FROM vsk_admins
                WHERE title = :title
                AND disabled = 0
                AND deleted = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":title", $title);
        return $command->queryRow();
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update vsk_admins set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

}