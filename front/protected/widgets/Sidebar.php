<?php

class Sidebar extends CWidget {

    public function init() {
        
    }
    
    public function run(){
        $role = UserControl::getRole();
        $this->render('sidebar-'.$role);
    }
}