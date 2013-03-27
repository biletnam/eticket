<?php

class SlideModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();
        
        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND bp.title like :title";            
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['post_type'])){
            $custom.= " AND bp.post_type = :post_type";
            $params[] = array('name' => ':post_type', 'value' => $args['post_type'],'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['deleted'])){
            $custom.= " AND bp.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'],'type'=>PDO::PARAM_INT);
        }
        
        if(isset($args['disabled'])){
            $custom.= " AND bp.disabled = :disabled";
            $params[] = array('name' => ':disabled', 'value' => $args['disabled'],'type'=>PDO::PARAM_INT);
        }

        $sql = "SELECT *
                FROM etk_posts bp
                WHERE 1
                $custom
                ORDER BY bp.title ASC
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
            $custom.= " AND bp.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['post_type'])){
            $custom.= " AND bp.post_type = :post_type";
            $params[] = array('name' => ':post_type', 'value' => $args['post_type'],'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['deleted'])){
            $custom.= " AND bp.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'],'type'=>PDO::PARAM_INT);
        }
        
        if(isset($args['disabled'])){
            $custom.= " AND bp.disabled = :disabled";
            $params[] = array('name' => ':disabled', 'value' => $args['disabled'],'type'=>PDO::PARAM_INT);
        }
        

        $sql = "SELECT count(*) as total
                FROM etk_posts bp
                WHERE 1
                $custom
                ";
        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);

        $count = $command->queryRow();
        return $count['total'];
    }


}