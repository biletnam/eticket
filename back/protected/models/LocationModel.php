<?php

class LocationModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 10) {
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

        $sql = "SELECT vc.*,ec.title as city
                FROM etk_locations vc
                   LEFT JOIN etk_cities ec
                    on vc.city_id = ec.id
                WHERE 1
                $custom
                ORDER BY vc.title ASC
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

        $sql = "SELECT count(*) as total
                FROM etk_locations vc
                WHERE 1
                $custom
                ORDER BY vc.title ASC
              ";

        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);

        $count = $command->queryRow();
        return $count['total'];
    }

    public function get($id) {
        $sql = "SELECT *
                FROM etk_locations
                WHERE id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function add($title, $slug, $city, $address) {
        $count_slug = $this->check_exist_slug($slug);
        if ($count_slug > 0)
            $slug = $slug . "-" . $count_slug;
        $time = time();

        $sql = "INSERT INTO etk_locations(title,slug,city_id,address,date_added) VALUES(:title,:slug,:city_id,:address,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":title", $title);
        $command->bindParam(":slug", $slug);
        $command->bindParam(":city_id", $city);
        $command->bindParam(":address", $address);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    private function check_exist_slug($slug) {
        $sql = 'SELECT count(slug) as count FROM etk_locations WHERE slug REGEXP "^' . $slug . '(-[[:digit:]]+)?$"';
        $command = Yii::app()->db->createCommand($sql);
        $row = $command->queryRow();
        return $row['count'];
    }
    
    public function get_cities(){
        $sql = "SELECT *
                FROM etk_cities
                WHERE deleted = 0";
        
          $command = Yii::app()->db->createCommand($sql);


        return $command->queryAll();
    }
    
       public function update($args) {

        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_locations set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

}