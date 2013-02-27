<?php

class EventModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {
        $page = ($page - 1) * $ppp;
        $custom = "";
        $params = array();
        
        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND ve.title like :title";            
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['deleted'])){
            $custom.= " AND ve.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'],'type'=>PDO::PARAM_INT);
        }
        

        $sql = "SELECT ve.*,va.email as author,vl.title as location, vl.address,vl.city
                FROM vsk_events ve
                LEFT JOIN vsk_users va
                ON va.id = ve.id
                LEFT JOIN vsk_locations vl
                ON vl.id = ve.location_id
                WHERE 1
                $custom
                ORDER BY ve.date_added DESC
                LIMIT :page,:ppp";
        
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":page", $page, PDO::PARAM_INT);
        $command->bindParam(":ppp", $ppp, PDO::PARAM_INT);
        foreach ($params as $a)        
            $command->bindParam($a['name'], $a['value'], $a['type']);
        

        return $this->_parse_events($command->queryAll());
    }

    public function counts($args) {

        $custom = "";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND ve.title like :title";            
            $params[] = array('name' => ':title', 'value' => "%$args[s]%",'type'=>PDO::PARAM_STR);
        }
        
        if(isset($args['deleted'])){
            $custom.= " AND ve.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'],'type'=>PDO::PARAM_INT);
        }

        $sql = "SELECT count(*) as total
                FROM vsk_events ve
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
        $sql = "SELECT ve.*,va.email as author,va.id as author_id,vl.title as location, vl.address,vl.city
                FROM vsk_events ve
                LEFT JOIN vsk_users va
                ON va.id = ve.user_id
                LEFT JOIN vsk_locations vl
                ON vl.id = ve.location_id
                WHERE ve.id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $this->_parse_events($command->queryRow());
    }
    
    private function _parse_events($events){
        if(!$events)
            return $events;
        if(isset($events[0]))
            foreach($events as $k=>$v)
                $events[$k]['categories'] = $this->get_event_category ($v['id']);
        else
            $events['categories'] = $this->get_event_category ($events['id']);
        return $events;
    }

    public function add($args) {

        $count_slug = $this->check_exist_slug($args['slug']);
        if ($count_slug > 0)
            $slug = $slug . "-" . $count_slug;
        $time = time();

        $sql = "INSERT INTO vsk_events(user_id,title,slug,location_id,start_time,end_time,display_start_time,display_end_time,img,thumbnail,description,published,show_tickets,is_repeat,date_added) 
                                    VALUES(:user_id,:title,:slug,:location_id,:start_time,:end_time,:display_start_time,:display_end_time,:img,:thumbnail,:description,:published,:show_tickets,:is_repeat,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $args['user_id'],PDO::PARAM_INT);
        $command->bindParam(":title", $args['title']);
        $command->bindParam(":slug", $args['slug']);
        $command->bindParam(":location_id", $args['location_id'],PDO::PARAM_INT);
        $command->bindParam(":start_time", $args['start_time']);
        $command->bindParam(":end_time", $args['end_time']);
        $command->bindParam(":display_start_time", $args['display_start_time']);
        $command->bindParam(":display_end_time", $args['display_end_time']);
        $command->bindParam(":description", $args['description']);
        $command->bindParam(":published", $args['published']);
        $command->bindParam(":show_tickets", $args['show_tickets'],PDO::PARAM_INT);
        $command->bindParam(":is_repeat", $args['is_repeat'],PDO::PARAM_INT);
        $command->bindParam(":img", $args['img']);
        $command->bindParam(":thumbnail", $args['thumbnail']);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    private function check_exist_slug($slug) {
        $sql = 'SELECT count(slug) as count FROM vsk_categories WHERE slug REGEXP "^' . $slug . '(-[[:digit:]]+)?$"';
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
        $sql = 'update vsk_events set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }
    
    public function add_event_category($event_id,$category_id,$is_primary){
        $sql = "INSERT INTO vsk_event_category(event_id,category_id,is_primary) VALUES(:event_id,:category_id,:is_primary)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':event_id', $event_id,PDO::PARAM_INT);
        $command->bindParam(':category_id', $category_id,PDO::PARAM_INT);
        $command->bindParam(':is_primary', $is_primary,PDO::PARAM_BOOL);
        return $command->execute();
    }
    
    public function get_event_category($event_id){
        $sql = "SELECT vc.*,vec.is_primary
                FROM vsk_event_category vec
                LEFT JOIN vsk_categories vc
                ON vc.id = vec.category_id
                WHERE vec.event_id = :event_id
                AND vc.deleted = 0
                AND vc.disabled = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':event_id', $event_id,PDO::PARAM_INT);
        $categories = $command->queryAll();
        $tmp = array();
        foreach($categories as $v){
            $type = $v['is_primary'] ? "primary" : "second";
            $tmp[$type] = $v;
        }
        return $tmp;
    }
    
    public function delete_event_category($event_id){
        $sql = "DELETE FROM vsk_event_category WHERE event_id = :event_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':event_id', $event_id,PDO::PARAM_INT);
        return $command->execute();
    }
    
    public function get_metas($event_id){
        $sql = "SELECT *
                FROM vsk_event_metas
                WHERE event_id = :event_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":event_id", $event_id,PDO::PARAM_INT);
        return $this->_parse_metas($command->queryAll());
                
    }
    
    private function _parse_metas($metas){
        $tmp_metas = array();
        foreach($metas as $k=>$v){
            $tmp_metas[$v['meta_key']] = $v['meta_value'];
        }
        return $tmp_metas;
    }
    
    public function update_metas($meta_key,$meta_value,$event_id){
        $meta = $this->get_meta($meta_key,$event_id);
        if(!$meta)
            return $this->add_meta ($meta_key, $meta_value, $event_id);
        
        $sql = "UPDATE vsk_event_metas
                SET meta_value = :meta_value
                WHERE id = :id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_value", $meta_value);
        $command->bindParam(":id", $meta['id'],PDO::PARAM_INT);
        return $command->execute();
    }
    
    public function get_meta($meta_key,$event_id){
        $sql = "SELECT *
                FROM vsk_event_metas
                WHERE meta_key = :meta_key
                AND event_id = :event_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_key", $meta_key);
        $command->bindParam(":event_id", $event_id,PDO::PARAM_INT);
        return $command->queryRow();
    }
    
    public function add_meta($meta_key,$meta_value,$event_id){
        $sql = "INSERT INTO vsk_event_metas(meta_key,meta_value,event_id) VALUES(:meta_key,:meta_value,:event_id)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":meta_key", $meta_key);
        $command->bindParam(":meta_value", $meta_value);
        $command->bindParam(":event_id", $event_id,PDO::PARAM_INT);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
}