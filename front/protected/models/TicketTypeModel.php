<?php

class TicketTypeModel extends CFormModel {

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
            $custom.= " AND vc.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['type'])) {
            $custom.= " AND vc.type = :type";
            $params[] = array('name' => ':type', 'value' => $args['type'], 'type' => PDO::PARAM_STR);
        }

        if (isset($args['event_id'])) {
            $custom.= " AND vc.event_id = :event_id";
            $params[] = array('name' => ':event_id', 'value' => $args['event_id'], 'type' => PDO::PARAM_INT);
        }

        $sql = "SELECT vc.*,vt.total_ticket,(vc.quantity - vt.total_ticket) as remaining
                FROM vsk_ticket_types vc
                LEFT JOIN (SELECT count(*) as total_ticket,ticket_type_id
                            FROM vsk_tickets 
                            WHERE deleted = 0
                            AND (status = 1 OR (status = 0 AND date_expired > UNIX_TIMESTAMP()) )
                            GROUP BY ticket_type_id) vt
                ON vt.ticket_type_id = vc.id
                WHERE 1
                $custom
                ORDER BY vc.date_added DESC
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
            $custom.= " AND vc.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['type'])) {
            $custom.= " AND vc.type = :type";
            $params[] = array('name' => ':type', 'value' => $args['type'], 'type' => PDO::PARAM_STR);
        }

        if (isset($args['event_id'])) {
            $custom.= " AND vc.event_id = :event_id";
            $params[] = array('name' => ':event_id', 'value' => $args['event_id'], 'type' => PDO::PARAM_INT);
        }

        $sql = "SELECT count(*) as total
                FROM vsk_ticket_types vc
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
                FROM vsk_ticket_types vtt
                LEFT JOIN vsk_events ve
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
        $sql = 'update vsk_ticket_types set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

    public function add($args) {
        $time = time();
        $sql = "INSERT INTO vsk_ticket_types(event_id,type,title,quantity,price,tax,ticket_status,description,hide_description,sale_start,sale_end,minimum,maximum,service_fee,date_added) VALUES(:event_id,:type,:title,:quantity,:price,:tax,:ticket_status,:description,:hide_description,:sale_start,:sale_end,:minimum,:maximum,:service_fee,:date_added)";
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