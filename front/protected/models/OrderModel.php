<?php

class OrderModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();
        
        if (isset($args['user_id'])) {
            $custom.= " AND etko.user_id = :user_id";            
            $params[] = array('name' => ':user_id', 'value' => $args['user_id'],'type'=>PDO::PARAM_STR);
        }
        
        if (isset($args['event_id'])) {
            $custom.= " AND etko.event_id = :event_id";            
            $params[] = array('name' => ':event_id', 'value' => $args['event_id'],'type'=>PDO::PARAM_STR);
        }
        
        if (isset($args['status'])) {
            $custom.= " AND etko.status = :status";            
            $params[] = array('name' => ':status', 'value' => $args['status'],'type'=>PDO::PARAM_STR);
        }

        $sql = "SELECT etko.*,ee.title as event_title,ee.slug as event_slug
                FROM etk_orders etko
                LEFT JOIN etk_events ee
                ON ee.id = etko.event_id
                WHERE 1
                $custom
                ORDER BY etko.date_added DESC
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
            $custom.= " AND etko.user_id = :user_id";            
            $params[] = array('name' => ':user_id', 'value' => $args['user_id'],'type'=>PDO::PARAM_STR);
        }
        
        if (isset($args['event_id'])) {
            $custom.= " AND etko.event_id = :event_id";            
            $params[] = array('name' => ':event_id', 'value' => $args['event_id'],'type'=>PDO::PARAM_STR);
        }
        
        if (isset($args['status'])) {
            $custom.= " AND etko.status = :status";            
            $params[] = array('name' => ':status', 'value' => $args['status'],'type'=>PDO::PARAM_STR);
        }

        $sql = "SELECT count(*) as total
                FROM etk_orders etko
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
        $sql = "SELECT so.*,sc.title as city_title
                FROM etk_orders so
                LEFT JOIN etk_cities sc
                ON sc.id = so.city_id
                WHERE so.id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }
    
    public function get_details($order_id){
        $sql = "SELECT sod.*,ett.type,ett.title
                FROM etk_orders_details sod
                LEFT JOIN etk_ticket_types ett
                ON ett.id = sod.ticket_type_id
                WHERE sod.order_id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $order_id, PDO::PARAM_INT);
        return $command->queryAll();
    }

    public function add($user_id,$event_id,$user_ip,$user_agent,$use_payment) {
        $time = time();
        $sql = "INSERT INTO etk_orders(user_id,event_id,status,user_ip,user_agent,date_added,use_payment) VALUES(:user_id,:event_id,'pending',:user_ip,:user_agent,:date_added,:use_payment)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $user_id,PDO::PARAM_INT);
        $command->bindParam(":event_id", $event_id,PDO::PARAM_INT);
        $command->bindParam(":user_ip", $user_ip);
        $command->bindParam(":user_agent", $user_agent);
        $command->bindParam(":date_added", $time);        
        $command->bindParam(":use_payment", $use_payment);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
    
    public function add_detail($order_id,$ticket_type_id,$quantity,$price,$fee,$total) {
        
        $sql = "INSERT INTO etk_orders_details(order_id,ticket_type_id,quantity,price,fee,total) VALUES(:order_id,:ticket_type_id,:quantity,:price,:fee,:total)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":order_id", $order_id,PDO::PARAM_INT);
        $command->bindParam(":ticket_type_id", $ticket_type_id);
        $command->bindParam(":quantity", $quantity);
        $command->bindParam(":price", $price);
        $command->bindParam(":fee", $fee);
        $command->bindParam(":total", $total);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
    
    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_orders set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }
    
}