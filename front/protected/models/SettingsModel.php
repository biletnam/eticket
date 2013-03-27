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

    public function get_usd() {

        $sql = "SELECT *
                FROM etk_site_options
                WHERE id = 2
                ORDER BY id";
        
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryRow();
    }

   public function get_ttd() {

        $sql = "SELECT *
                FROM etk_site_options
                WHERE id = 1
                ORDER BY id";
        
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryRow();
    }

}