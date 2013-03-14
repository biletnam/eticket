<?php

class OrganizerModel extends CFormModel {

    public function __construct() {
        
    }
    
    public function get_by_user($id) {
        $sql = "SELECT *
                FROM etk_organizers
                WHERE user_id = :id
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->queryRow();
    }
    
    public function add($user_id) {
        
        $time = time();
        $time = time();
        $sql = "INSERT INTO etk_organizers(user_id,date_added) VALUES(:user_id,:date_added)";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":user_id", $user_id);
        $command->bindParam(":date_added", $time);
        $command->execute();
        return Yii::app()->db->lastInsertID;
    }
    
    private function check_exist_slug($slug) {
        $sql = 'SELECT count(slug) as count FROM etk_organizers WHERE slug REGEXP "^' . $slug . '(-[[:digit:]]+)?$"';
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
        $sql = 'update etk_organizers set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }
}