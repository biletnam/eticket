<?php

class AccountController extends Controller {

    public function actions() {
        
    }

    public function actionIndex() {
    }
    
    public function actionMyEvents() {
        $this->render('myevents');
    }
    public function actionMyTickets() {
        $this->render('mytickets');
    }
    public function actionMyContacts() {
        $this->render('mycontacts');
    }
}