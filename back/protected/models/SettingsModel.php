<?php

class SettingsModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets() {

        $sql = "SELECT *
                FROM etk_site_options
                WHERE 1
                ORDER BY id";
        
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }


    public function update($args) {
        $keys = array_keys($args);
        $custom = '';
        foreach ($keys as $k)
            $custom .= $k . ' = :' . $k . ', ';
        $custom = substr($custom, 0, strlen($custom) - 2);
        $sql = 'update etk_site_options set ' . $custom . ' where id = :id';
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute($args);
    }

}