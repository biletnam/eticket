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

    public function get($id) {
        $sql = "SELECT *
                FROM etk_posts
                WHERE id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }

    public function add($user_id,$title, $slug,$content,$img,$thumbnail,$post_type) {

        $count_slug = $this->check_exist_slug($slug);
        if ($count_slug > 0)
            $slug = $slug . "-" . $count_slug;
        $time = time();
        $disabled = 0;

        $sql = "INSERT INTO etk_posts(user_id,title,slug,content,img,thumbnail,date_added,post_type,disabled) VALUES(:user_id,:title,:slug,:content,:img,:thumbnail,:date_added,:post_type,:disabled)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $user_id);
        $command->bindParam(":title", $title);
        $command->bindParam(":slug", $slug);
        $command->bindParam(":date_added", $time);
        $command->bindParam(":content", $content);
        $command->bindParam(":img", $img);
        $command->bindParam(":thumbnail", $thumbnail);
        $command->bindParam(":post_type", $post_type);
        $command->bindParam(":disabled", $disabled);
        $command->execute();
        
        return Yii::app()->db->lastInsertID;
    }

    private function check_exist_slug($slug) {
        $sql = 'SELECT count(slug) as count FROM etk_posts WHERE slug REGEXP "^' . $slug . '(-[[:digit:]]+)?$"';
        $command = Yii::app()->db->createCommand($sql);
        $row = $command->queryRow();
        return $row['count'];
    }

    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_posts set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

}