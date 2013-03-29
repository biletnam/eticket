<?php

class CountryModel extends CFormModel {

    public function __construct() {
        
    }

    public function gets_all_countries() {
        $sql = "SELECT *
                FROM etk_countries
                WHERE deleted=0
                ";
        $command = Yii::app()->db->createCommand($sql);
        return $command->queryAll();
    }
}