<?php

class OrganizerController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $OrganizerModel;

    public function init() {

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $OrganizerModel OrganizerModel */
        $this->OrganizerModel = new OrganizerModel();
    }

    public function actionIndex($p = 1) {

        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $args = array('s' => $s, 'deleted' => 0);

        $organizers = $this->OrganizerModel->gets($args, $p, $ppp);
        $total = $this->OrganizerModel->counts($args);

        $this->viewData['organizers'] = $organizers;
        $this->viewData['total'] = $total;
        $this->viewData['paging'] = $total > $ppp ? HelperApp::get_paging($ppp, Yii::app()->request->baseUrl . "/location/index/p/", $total, $p) : "";

        $this->render('index', $this->viewData);
    }

    public function actionEdit($id = "") {
        $this->CheckPermission();
        $organizer = $this->OrganizerModel->get($id);
        if (!$organizer)
            $this->load_404();
        if ($_POST)
            $this->do_edit($organizer);

        $this->viewData['message'] = $this->message;
        $this->viewData['organizer'] = $organizer;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($organizer) {
        $title = trim($_POST['title']);
        $file = $_FILES['file'];
        $description = trim($_POST['description']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter title.";
        if (!$this->validator->is_empty_string($file['name']) && !$this->validator->is_valid_image($file))
            $this->message['error'][] = "The file you are trying to upload is invalid. Make sure it is a valid image and that the filename ends with a .jpg, .gif or .png extension";


        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $img = $organizer['img'];
        $thumbnail = $organizer['thumbnail'];

        if (!$this->validator->is_empty_string($file['name'])) {
            $resize = HelperApp::resize_images($file, HelperApp::get_organizer_sizes());
            $img = $resize['img'];
            $thumbnail = $resize['thumbnail'];
        }

        $this->OrganizerModel->update(array('title' => $title, 'description' => $description, 'img' => $img,'thumbnail'=>$thumbnail, 'id' => $organizer['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $organizer, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/organizer/edit/id/$organizer[id]/?s=1");
    }

    public function actionDelete($id) {
        $this->CheckPermission();
        $organizer = $this->OrganizerModel->get($id);
        if (!$organizer)
            return;

        $this->OrganizerModel->update(array('deleted' => 1, 'id' => $id));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Deleted', 'Data' => array('id' => $id)));
    }

}