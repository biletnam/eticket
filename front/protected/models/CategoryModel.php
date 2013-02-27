<?php

class CategoryModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();
        
        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND vc.title like :title";            
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['deleted'])){
            $custom.= " AND vc.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'],'type'=>PDO::PARAM_INT);
        }
        
        if(isset($args['disabled'])){
            $custom.= " AND vc.disabled = :disabled";
            $params[] = array('name' => ':disabled', 'value' => $args['disabled'],'type'=>PDO::PARAM_INT);
        }
        
        if(isset($args['type'])){
            $custom.= " AND vc.type = :type";
            $params[] = array('name' => ':type', 'value' => $args['type'],'type'=>PDO::PARAM_STR);
        }

        $sql = "SELECT *
                FROM vsk_categories vc
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
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['deleted'])){
            $custom.= " AND vc.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'],'type'=>PDO::PARAM_INT);
        }
        
        if(isset($args['disabled'])){
            $custom.= " AND vc.disabled = :disabled";
            $params[] = array('name' => ':disabled', 'value' => $args['disabled'],'type'=>PDO::PARAM_INT);
        }
        
        if(isset($args['type'])){
            $custom.= " AND vc.type = :type";
            $params[] = array('name' => ':type', 'value' => $args['type'],'type'=>PDO::PARAM_STR);
        }

        $sql = "SELECT count(*) as total
                FROM vsk_categories vc
                WHERE 1
                $custom
                ";
        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);

        $count = $command->queryRow();
        return $count['total'];
    }
    
    public function get_popular_event_categories(){
        $sql = "SELECT vc.*,vec.total_event
                FROM vsk_categories vc
                LEFT JOIN (SELECT category_id,count(*) as total_event
                            FROM vsk_event_category
                            GROUP BY category_id) vec
                ON vec.category_id = vc.id
                WHERE type = 'event'
                AND deleted = 0
                AND disabled = 0
                AND featured = 1
                ORDER BY vec.total_event DESC
                LIMIT 5";
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }

    public function get($id) {
        $sql = "SELECT *
                FROM vsk_categories
                WHERE id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }
    
    public function get_by_slug($slug) {
        $sql = "SELECT *
                FROM vsk_categories
                WHERE slug = :slug
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":slug", $slug, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update vsk_categories set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }
    
    

}