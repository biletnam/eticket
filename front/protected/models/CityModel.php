<?php

class CityModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets_all_cities() {
        $sql = "SELECT *
                FROM etk_cities
                ";
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }
}