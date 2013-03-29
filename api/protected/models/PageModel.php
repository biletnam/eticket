<?php

class PageModel extends CFormModel {

    public function __construct() {
        
    }
    
    public function get_by_slug($slug) {
        $sql = "SELECT *
                FROM etk_posts
                WHERE slug = :slug
                AND post_type = 'page'
                ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":slug", $slug);
        return $command->queryRow();
    }
}