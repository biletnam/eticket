<?php

class TicketTypeModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND ett.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['deleted'])) {
            $custom.= " AND ett.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['type'])) {
            $custom.= " AND ett.type = :type";
            $params[] = array('name' => ':type', 'value' => $args['type'], 'type' => PDO::PARAM_STR);
        }

        if (isset($args['event_id'])) {
            $custom.= " AND ett.event_id = :event_id";
            $params[] = array('name' => ':event_id', 'value' => $args['event_id'], 'type' => PDO::PARAM_INT);
        }

        $sql = "SELECT ett.*,et.total_ticket,(ett.quantity - et.total_ticket) as remaining
                FROM etk_ticket_types ett
                LEFT JOIN (SELECT count(*) as total_ticket,ticket_type_id
                            FROM etk_tickets 
                            WHERE deleted = 0                            
                            GROUP BY ticket_type_id) et
                ON et.ticket_type_id = ett.id
                WHERE 1
                $custom
                ORDER BY ett.date_added DESC
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

        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND ett.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['deleted'])) {
            $custom.= " AND ett.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['type'])) {
            $custom.= " AND ett.type = :type";
            $params[] = array('name' => ':type', 'value' => $args['type'], 'type' => PDO::PARAM_STR);
        }

        if (isset($args['event_id'])) {
            $custom.= " AND ett.event_id = :event_id";
            $params[] = array('name' => ':event_id', 'value' => $args['event_id'], 'type' => PDO::PARAM_INT);
        }

        $sql = "SELECT count(*) as total
                FROM etk_ticket_types ett
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
        $sql = "SELECT vtt.*,ve.user_id as author_id
                FROM etk_ticket_types vtt
                LEFT JOIN etk_events ve
                ON ve.id = vtt.event_id
                WHERE vtt.deleted = 0
                AND vtt.id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_ticket_types set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

    public function add($args) {
        $time = time();
        $sql = "INSERT INTO etk_ticket_types(event_id,type,title,quantity,price,tax,ticket_status,description,hide_description,sale_start,sale_end,minimum,maximum,service_fee,date_added) 
            VALUES(:event_id,:type,:title,:quantity,:price,:tax,:ticket_status,:description,:hide_description,:sale_start,:sale_end,:minimum,:maximum,:service_fee,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":event_id", $args['event_id']);
        $command->bindParam(":type", $args['type']);
        $command->bindParam(":title", $args['title']);
        $command->bindParam(":quantity", $args['quantity']);
        $command->bindParam(":price", $args['price']);
        $command->bindParam(":tax", $args['tax']);
        $command->bindParam(":ticket_status", $args['ticket_status']);
        $command->bindParam(":description", $args['description']);
        $command->bindParam(":hide_description", $args['hide_description']);
        $command->bindParam(":sale_start", $args['sale_start']);
        $command->bindParam(":sale_end", $args['sale_end']);
        $command->bindParam(":minimum", $args['minimum']);
        $command->bindParam(":maximum", $args['maximum']);
      
        $command->bindParam(":service_fee", $args['service_fee']);
        $command->bindParam(":date_added", $time);

        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    public function gets_by_event($id) {
        $sql = "SELECT * FROM etk_ticket_types ett
                WHERE ett.event_id = :id
                AND ett.deleted = 0
                AND ett.quantity != 0";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);

        return $command->queryAll();
    }
    
    
    public function get_tmp_quantity($id) {
        $sql = "SELECT SUM(eod.quantity) as tmp_quantity
                FROM etk_orders_details eod,etk_orders eo,etk_event_tokens eet
                WHERE eod.order_id = eo.id
                AND eet.order_id = eo.id
                AND eet.date_expired > UNIX_TIMESTAMP()
                AND eo.`status` != 'completed'
                AND eod.ticket_type_id = :id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        $total = $command->queryRow();
        return $total['tmp_quantity'];
    }
}