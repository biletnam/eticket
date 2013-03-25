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

    public function actionIndex($p = 1) {

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

        $countries = $this->LocationModel->get_countries(array('deleted' => 0), 1, 200);

        $this->viewData['countries'] = $countries;
        $this->viewData['message'] = $this->message;
        $this->render('add', $this->viewData);
    }

    private function do_add() {
        $title = trim($_POST['title']);
        $city = trim($_POST['city']);
        $country = $_POST['country'];
        $address = trim($_POST['address']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter location title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $location_id = $this->LocationModel->add($title, Helper::create_slug($title), $country,$city, $address);
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

        $countries = $this->LocationModel->get_countries(array('deleted' => 0), 1, 200);

        $this->viewData['countries'] = $countries;
        $this->viewData['message'] = $this->message;
        $this->viewData['location'] = $location;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($location) {
        $title = trim($_POST['title']);
        $city = trim($_POST['city']);
        $country = $_POST['country'];
        $address = trim($_POST['address']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter location title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $this->LocationModel->update(array('title' => $title, 'country_id' => $$country, 'city_title' => $city ,'address' => $address, 'id' => $location['id']));
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


    public function actionCountry($p = 1) {

        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $args = array('s' => $s, 'deleted' => 0);

        $countries = $this->LocationModel->get_countries($args, $p, $ppp);
        $total = $this->LocationModel->count_countries($args);

        $this->viewData['countries'] = $countries;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/location/country/p/", $total, $p) : "";

        $this->render('country', $this->viewData);
    }

    public function actionAdd_country() {

        $this->CheckPermission();
        if ($_POST)
            $this->do_add_country();


        $this->viewData['message'] = $this->message;
        $this->render('add_country', $this->viewData);
    }

    private function do_add_country() {
        $title = trim($_POST['title']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter city title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $location_id = $this->LocationModel->add_country($title, Helper::create_slug($title));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Add', 'Data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/location/edit_country/id/$location_id/?s=1");
    }

    public function actionEdit_country($id = "") {
        $this->CheckPermission();
        $country = $this->LocationModel->get_country($id);
        if (!$country)
            $this->load_404();
        if ($_POST)
            $this->do_edit_country($country);

        $this->viewData['message'] = $this->message;
        $this->viewData['country'] = $country;
        $this->render('edit_country', $this->viewData);
    }

    private function do_edit_country($country) {
        $title = trim($_POST['title']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter city title.";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $this->LocationModel->update_country(array('title' => $title, 'deleted' => $_POST['deleted'], 'id' => $country['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $country, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/location/edit_country/id/$country[id]/?s=1");
    }

    public function actionDelete_country($id) {
        $this->CheckPermission();
        $country = $this->LocationModel->get_country($id);
        if (!$country)
            return;

        $this->LocationModel->update_country(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Deleted', 'Data' => array('id' => $id)));
    }

}