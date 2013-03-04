<?php

class HomeController extends Controller {

    private $viewData;
    private $EventModel;
    private $TicketModel;
    private $TicketTypeModel;
    private $CategoryModel;

    public function init() {
        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();

        /* @var $TicketModel TicketModel */
        $this->TicketModel = new TicketModel();

        /* @var $TicketTypeModel TicketTypeModel */
        $this->TicketTypeModel = new TicketTypeModel();

        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();
    }

    public function actions() {
        
    }

    public function actionTest() {
        $time = microtime(true);

        $con = mysql_connect("127.0.0.1", "root", "");
        mysql_select_db("mysql", $con);

        $con_time = microtime(true);

        $result = mysql_query('SELECT host,user,password FROM user;');

        $sel_time = microtime(true);

        printf("Connect time: %f\nQuery time: %f\n", $con_time - $time, $sel_time - $con_time);
    }

    public function actionIndex() {
        $events = $this->EventModel->gets(array('deleted' => 0, 'is_today' => 1, 'published' => 1), 1, 5);
        $popular_events = $this->EventModel->get_popular_events();
        $popular_event_categories = $this->CategoryModel->get_popular_event_categories();

        $this->viewData['events'] = $events;
        $this->viewData['popular_events'] = $popular_events;
        $this->viewData['popular_categories'] = $popular_event_categories;
        $this->render('index', $this->viewData);
    }

    public function actionContact_us() {
        $this->render('contact');
    }

    public function actionError404() {
        $this->layout = "404";
        $this->render("error");
    }

}