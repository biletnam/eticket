<?php

class TicketModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND vc.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['deleted'])) {
            $custom.= " AND et.deleted = :deleted";
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

        if (isset($args['ticket_type_id'])) {
            $custom.= " AND et.ticket_type_id = :ticket_type_id";
            $params[] = array('name' => ':ticket_type_id', 'value' => $args['ticket_type_id'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['status'])) {
            $custom.= " AND et.status = :status";
            $params[] = array('name' => ':status', 'value' => $args['status'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['check_date_expired'])) {

            $custom.= " AND (vt.status = 1 OR (vt.status = 0 AND vt.date_expired > UNIX_TIMESTAMP()) )";
        }

        $sql = "SELECT et.*,ett.title as ticket_type_name,ee.title as event_name,ett.event_id
                FROM etk_tickets et
                LEFT JOIN etk_ticket_types ett
                ON ett.id = et.ticket_type_id
                LEFT JOIN etk_events ve
                ON ee.id = ett.event_id
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

        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND vc.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['deleted'])) {
            $custom.= " AND et.deleted = :deleted";
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

        if (isset($args['ticket_type_id'])) {
            $custom.= " AND et.ticket_type_id = :ticket_type_id";
            $params[] = array('name' => ':ticket_type_id', 'value' => $args['ticket_type_id'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['status'])) {
            $custom.= " AND et.status = :status";
            $params[] = array('name' => ':status', 'value' => $args['status'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['check_date_expired'])) {

            $custom.= " AND (et.status = 1 OR (et.status = 0 AND et.date_expired > UNIX_TIMESTAMP()) )";
        }

        $sql = "SELECT count(*) as total
                FROM etk_tickets et
                LEFT JOIN etk_ticket_types ett
                ON ett.id = et.ticket_type_id
                LEFT JOIN etk_events ee
                ON ee.id = ett.event_id
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
        $sql = "SELECT ett.*,ee.user_id as author_id
                FROM etk_ticket_types ett
                LEFT JOIN etk_events ee
                ON ee.id = ett.event_id
                WHERE ett.deleted = 0
                AND ett.id = :id
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
        $sql = 'update vsk_ticket set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

    public function add($args) {
        $time = time();
        $sql = "INSERT INTO etk_ticket_types(event_id,type,title,quantity,price,tax,ticket_status,description,hide_description,sale_start,sale_end,minimum,maximum,service_fee,date_added) VALUES(:event_id,:type,:title,:quantity,:price,:tax,:ticket_status,:description,:hide_description,:sale_start,:sale_end,:minimum,:maximum,:service_fee,:date_added)";
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

  

}