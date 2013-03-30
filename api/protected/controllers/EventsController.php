<?php

class EventsController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $CategoryModel;
    private $EventModel;
    private $LocationModel;
    private $TicketTypeModel;
    private $TicketModel;
    private $OrderModel;
    private $CountryModel;
    private $TrackingModel;
    private $PaypalModel;
    private $SettingsModel;

    public function init() {
        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $CategoryModel CategoryModel */
        $this->CategoryModel = new CategoryModel();

        /* @var $EventModel EventModel */
        $this->EventModel = new EventModel();

        /* @var $LocationModel LocationModel */
        $this->LocationModel = new LocationModel();

        /* @var $TicketTypeModel TicketTypeModel */
        $this->TicketTypeModel = new TicketTypeModel();

        /* @var $TicketModel TicketModel */
        $this->TicketModel = new TicketModel();

        /* @var $OrderModel OrderModel */
        $this->OrderModel = new OrderModel();

        /* @var $CountryModel CountryModel */
        $this->CountryModel = new CountryModel();

        /* @var $TrackingModel TrackingModel */
        $this->TrackingModel = new TrackingModel();

        /* @var $PaypalModel PaypalModel */
        $this->PaypalModel = new PaypalModel();

        /* @var $SettingsModel SettingsModel */
        $this->SettingsModel = new SettingsModel();
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        
    }
    
    public function actionCode_access() {
        
        $str = "eTicket";
        $base = "2013";
        //echo base64_encode($base);
        echo sha1(sha1($str) . $base);die;

        //for generate apikey of user
        $apikey = "dMxK3uFUh" . Ultilities::base32UUID();
        echo sha1(base64_encode($apikey));
    }
    
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        HelperGlobal::CheckAccessToken();
        $events = $this->EventModel->gets(array('deleted' => 0, 'is_today' => 1, 'published' => 1,'disabled'=>0), 1, 12);
        HelperGlobal::return_data(array('events'=>$events), array('code' => 200, 'message' => $this->message['error']));        
    }
    
    public function actionDetail($s = ""){
        HelperGlobal::CheckAccessToken();
        $event = $this->EventModel->get_by_slug($s);
        if (!$event)
        {
            $this->message['error'][] = Helper::_error_code(404);
            HelperGlobal::return_data(array(), array('code' => 404, 'message' => $this->message['error']));            
        }
        
        $ticket_types = $this->TicketTypeModel->gets(array('deleted' => 0, 'event_id' => $event['id']), 1, 100);

        foreach ($ticket_types as $k => $v) {
            $tmp_quantity = $this->TicketTypeModel->get_tmp_quantity($v['id']);
            $total_paid_ticket = (int) $v['total_ticket'] == 0 ? 0 : $v['total_ticket'];
            $remaining = $v['quantity'] - $tmp_quantity - $total_paid_ticket;
            $v['remaining'] = $remaining;
            $v['total_ticket'] = $total_paid_ticket;
            $ticket_types[$k] = $v;
        }
        $this->viewData['ticket_types'] = $ticket_types;
        $this->viewData['event'] = $event;
        $this->viewData['message'] = $this->message;
        HelperGlobal::return_data($this->viewData, array('code' => 200, 'message' => $this->message['error']));  
    }

}