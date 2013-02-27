<?php

class LogModel extends CFormModel {

    public function __construct() {
        
    }
    
    public function gets($args,$page = 1,$ppp = 100){
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom = " AND va.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        $sql = "SELECT vl.*,va.title as author,va.role
                FROM vsk_logs vl
                LEFT JOIN vsk_admins va
                ON vl.admin_id = va.id
                WHERE 1
                $custom
                ORDER BY date_added DESC
                LIMIT :page,:ppp
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":page", $page, PDO::PARAM_INT);
        $command->bindParam(":ppp", $ppp, PDO::PARAM_INT);
        
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);
        
        return $command->queryAll();
    }
    
    public function counts($args){
        
        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom = " AND va.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        $sql = "SELECT count(*) as total
                FROM vsk_logs vl
                LEFT JOIN vsk_admins va
                ON vl.admin_id = va.id
                WHERE 1
                $custom
                ";
        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);
        
        $count = $command->queryRow();
        return $count['total'];
    }
    
    public function add($admin_id,$controller,$method,$ip,$description = ''){
        $time = time();
        $sql = "INSERT INTO vsk_logs(admin_id,access_controller,access_method,description,admin_ip,date_added) VALUES(:admin_id,:access_controller,:access_method,:description,:admin_ip,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":admin_id", $admin_id);
        $command->bindParam(":access_controller", $controller);
        $command->bindParam(":access_method", $method);
        $command->bindParam(":description", $description);
        $command->bindParam(":admin_ip", $ip);
        $command->bindParam(":date_added", $time);
        return $command->execute();
    }
}