<?php

class EventModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets($args, $page = 1, $ppp = 20) {

        $page = ($page - 1) * $ppp;
        $custom = "";
        $order_by = "ee.date_added DESC";
        $params = array();

        if (isset($args['s']) && $args['s'] != "") {
            $custom.= " AND ee.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['deleted'])) {
            $custom.= " AND ee.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['search_title']) && $args['search_title'] != "") {
            $custom.= " AND (ee.title like :search_title)";
            $params[] = array('name' => ':search_title', 'value' => "%$args[search_title]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['search_cate']) && $args['search_cate'] != "") {

            $custom.= " AND ee.id IN (SELECT event_id 
                                    FROM etk_event_category
                                    WHERE category_id = :category_id)";
            $params[] = array('name' => ':category_id', 'value' => $args['search_cate'], 'type' => PDO::PARAM_STR);
        }


        if (isset($args['search_city']) && $args['search_city'] != "") {
            $custom.= " AND (el.city_title like :search_city)";
            $params[] = array('name' => ':search_city', 'value' => "%$args[search_city]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['date']) && $args['date'] == "today") {
            $custom.= " AND DATE(ee.start_time)=DATE(NOW())";
        }

        if (isset($args['date']) && $args['date'] == "tomorrow") {
            $custom.= " AND DATE(ee.start_time)=DATE(NOW() + INTERVAL 1 DAY)";
        }

        if (isset($args['date']) && $args['date'] == "week") {
            $custom.= " AND YEAR(NOW()) = YEAR(ee.start_time) AND WEEKOFYEAR(NOW()) = WEEKOFYEAR(ee.start_time)";
        }

        if (isset($args['date']) && $args['date'] == "year") {
            $custom.= " AND YEAR(NOW()) = YEAR(ee.start_time)";
        }




        if (isset($args['published'])) {
            $custom.= " AND ee.published = :published";
            $params[] = array('name' => ':published', 'value' => $args['published'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['is_today']) && $args['is_today']) {

            $order_by = "ee.start_time ASC";
            $custom.= " AND DATE(start_time) >= DATE(NOW())";
        }

        $sql = "SELECT ee.*,va.email as author,el.title as location, el.address,el.title as location_title,ec.id as city_id,ec.title as city_title
                FROM etk_events ee
                LEFT JOIN etk_users va
                ON va.id = ee.id
                LEFT JOIN etk_locations el
                ON el.id = ee.location_id
                LEFT JOIN etk_cities ec
                ON ec.id = el.city_id
                WHERE 1
                $custom
                GROUP BY ee.id
                ORDER BY $order_by
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
            $custom.= " AND ee.title like :title";
            $params[] = array('name' => ':title', 'value' => "%$args[s]%", 'type' => PDO::PARAM_STR);
        }

        if (isset($args['deleted'])) {
            $custom.= " AND ee.deleted = :deleted";
            $params[] = array('name' => ':deleted', 'value' => $args['deleted'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['published'])) {
            $custom.= " AND ee.published = :published";
            $params[] = array('name' => ':published', 'value' => $args['published'], 'type' => PDO::PARAM_INT);
        }

        if (isset($args['is_today']) && $args['is_today']) {

            $custom.= " AND DATE(start_time) >= DATE(NOW())";
        }

        $sql = "SELECT count(*) as total
                FROM etk_events ee
                WHERE 1
                $custom
                ";
        $command = Yii::app()->db->createCommand($sql);
        foreach ($params as $a)
            $command->bindParam($a['name'], $a['value'], $a['type']);

        $count = $command->queryRow();
        return $count['total'];
    }

    public function get_popular_events() {
        $sql = "SELECT vt.total_ticket,ee.*,va.email as author,el.title as location, el.address,el.city
                FROM etk_events ee
                LEFT JOIN etk_users va
                ON va.id = ee.id
                LEFT JOIN etk_locations el
                ON el.id = ee.location_id
                LEFT JOIN (SELECT count(*) as total_ticket,event_id
                            FROM etk_tickets vt,etk_ticket_types vtt
                            WHERE vtt.id = vt.ticket_type_id
                            GROUP BY event_id) vt
                ON vt.event_id = ee.id
                
                WHERE ee.deleted = 0
                AND ee.disabled = 0
                AND ee.published = 1
                AND DATE(start_time) >= DATE(NOW())
                
                ORDER BY vt.total_ticket DESC
                LIMIT 3";

        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }

    public function get($id) {
        $sql = "SELECT ee.*,va.email as author,va.id as author_id,el.title as location, el.address,ec.id as city_id,ec.title as city_title
                FROM etk_events ee
                LEFT JOIN etk_users va
                ON va.id = ee.user_id
                LEFT JOIN etk_locations el
                ON el.id = ee.location_id
                LEFT JOIN etk_cities ec
                ON ec.id = el.city_id
                WHERE ee.id = :id
                AND ee.deleted = 0
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $this->_parse_events($command->queryRow());
    }

   

    public function get_by_slug($slug) {
        $sql = "SELECT ee.*,va.email as author,va.id as author_id,el.title as location, el.address,ec.id as city_id,ec.title as city_title
                FROM etk_events ee
                LEFT JOIN etk_users va
                ON va.id = ee.user_id
                LEFT JOIN etk_locations el
                ON el.id = ee.location_id
                LEFT JOIN etk_cities ec
                ON ec.id = el.city_id
                WHERE ee.slug = :slug
                AND ee.deleted = 0
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":slug", $slug);
        return $this->_parse_events($command->queryRow());
    }

    private function _parse_events($events) {
        if (!$events)
            return $events;
        if (isset($events[0]))
            foreach ($events as $k => $v)
                $events[$k]['categories'] = $this->get_event_category($v['id']);
        else
            $events['categories'] = $this->get_event_category($events['id']);
        return $events;
    }

    public function add($args) {

        $count_slug = $this->check_exist_slug($args['slug']);
        if ($count_slug > 0)
            $slug = $slug . "-" . $count_slug;
        $time = time();

        $sql = "INSERT INTO etk_events(user_id,title,slug,location_id,start_time,end_time,display_start_time,display_end_time,img,thumbnail,description,published,show_tickets,is_repeat,date_added) 
                                    VALUES(:user_id,:title,:slug,:location_id,:start_time,:end_time,:display_start_time,:display_end_time,:img,:thumbnail,:description,:published,:show_tickets,:is_repeat,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $args['user_id'], PDO::PARAM_INT);
        $command->bindParam(":title", $args['title']);
        $command->bindParam(":slug", $args['slug']);
        $command->bindParam(":location_id", $args['location_id'], PDO::PARAM_INT);
        $command->bindParam(":start_time", $args['start_time']);
        $command->bindParam(":end_time", $args['end_time']);
        $command->bindParam(":display_start_time", $args['display_start_time']);
        $command->bindParam(":display_end_time", $args['display_end_time']);
        $command->bindParam(":description", $args['description']);
        $command->bindParam(":published", $args['published']);
        $command->bindParam(":show_tickets", $args['show_tickets'], PDO::PARAM_INT);
        $command->bindParam(":is_repeat", $args['is_repeat'], PDO::PARAM_INT);
        $command->bindParam(":img", $args['img']);
        $command->bindParam(":thumbnail", $args['thumbnail']);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }

    private function check_exist_slug($slug) {
        $sql = 'SELECT count(slug) as count FROM etk_categories WHERE slug REGEXP "^' . $slug . '(-[[:digit:]]+)?$"';
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
        $sql = 'update etk_events set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

    public function add_event_category($event_id, $category_id, $is_primary) {
        $sql = "INSERT INTO etk_event_category(event_id,category_id,is_primary) VALUES(:event_id,:category_id,:is_primary)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $command->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $command->bindParam(':is_primary', $is_primary, PDO::PARAM_BOOL);
        return $command->execute();
    }

    public function get_event_category($event_id) {
        $sql = "SELECT vc.*,vec.is_primary
                FROM etk_event_category vec
                LEFT JOIN etk_categories vc
                ON vc.id = vec.category_id
                WHERE vec.event_id = :event_id
                AND vc.deleted = 0
                AND vc.disabled = 0";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $categories = $command->queryAll();
        $tmp = array();
        foreach ($categories as $v) {
            $type = $v['is_primary'] ? "primary" : "second";
            $tmp[$type] = $v;
        }
        return $tmp;
    }

    public function delete_event_category($event_id) {
        $sql = "DELETE FROM etk_event_category WHERE event_id = :event_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        return $command->execute();
    }

}