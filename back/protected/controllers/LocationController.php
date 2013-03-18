<?php

class LocationController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $LocationModel;

    public function init() {

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $LocationModel LocationModel */
        $this->LocationModel = new LocationModel();
    }

    public function actionIndex( $p = 1) {

        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $args = array('s' => $s, 'deleted' => 0);

        $location = $this->LocationModel->gets($args, $p, $ppp);
        $total = $this->LocationModel->counts($args);

        $this->viewData['location'] = $location;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/location/index/p/", $total, $p) : "";
        
        $this->render('index', $this->viewData);
    }

    public function actionAdd() {

        $this->CheckPermission();
        if ($_POST)
            $this->do_add();

        $cities = $this->LocationModel->get_cities(array('deleted'=>0),1,200);

        $this->viewData['cities'] = $cities;
        $this->viewData['message'] = $this->message;
        $this->render('add', $this->viewData);
    }

    private function do_add() {
        $title = trim($_POST['title']);
        $city = $_POST['city'];
        $address = trim($_POST['address']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter location title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $location_id = $this->LocationModel->add($title, Helper::create_slug($title), $city, $address);
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/location/edit/id/$location_id/?s=1");
    }

    public function actionEdit($id = "") {
        $this->CheckPermission();
        $location = $this->LocationModel->get($id);
        if (!$location)
            $this->load_404();
        if ($_POST)
            $this->do_edit($location);

        $cities = $this->LocationModel->get_cities(array('deleted'=>0),1,200);

        $this->viewData['cities'] = $cities;
        $this->viewData['message'] = $this->message;
        $this->viewData['location'] = $location;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($location) {
        $title = trim($_POST['title']);
        $city = $_POST['city'];
        $address = trim($_POST['address']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter location title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $this->LocationModel->update(array('title' => $title, 'city_id' => $city, 'address' => $address, 'id' => $location['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $location, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/location/edit/id/$location[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $category = $this->LocationModel->get($id);
        if (!$category)
            return;

        $this->LocationModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Deleted', 'Data' => array('id' => $id)));
    }
    
     public function actionCity( $p = 1) {

        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $args = array('s' => $s, 'deleted' => 0);

        $cities = $this->LocationModel->get_cities($args, $p, $ppp);
        $total = $this->LocationModel->count_cities($args);

        $this->viewData['cities'] = $cities;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/location/city/p/", $total, $p) : "";
    
        $this->render('city', $this->viewData);
    }
    
        public function actionAdd_city() {

        $this->CheckPermission();
        if ($_POST)
            $this->do_add_city();

      
        $this->viewData['message'] = $this->message;
        $this->render('add_city', $this->viewData);
    }

    private function do_add_city() {
        $title = trim($_POST['title']);
       
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter city title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $location_id = $this->LocationModel->add_city($title, Helper::create_slug($title));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/location/edit_city/id/$location_id/?s=1");
    }
    
    public function actionEdit_city($id = "") {
        $this->CheckPermission();
        $city = $this->LocationModel->get_city($id);
        if (!$city)
            $this->load_404();
        if ($_POST)
            $this->do_edit_city($city);

        $this->viewData['message'] = $this->message;
        $this->viewData['city'] = $city;
        $this->render('edit_city', $this->viewData);
    }

    private function do_edit_city($city) {
        $title = trim($_POST['title']);
     
        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter city title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $this->LocationModel->update_city(array('title' => $title,'deleted'=>$_POST['deleted'],'id'=>$city['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $city, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/location/edit_city/id/$city[id]/?s=1");
    }

    public function actionDelete_city($id) {
        $this->CheckPermission();
        $city = $this->LocationModel->get_city($id);
        if (!$city)
            return;

        $this->LocationModel->update_city(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Deleted', 'Data' => array('id' => $id)));
    }

}