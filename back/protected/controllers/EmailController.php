<?php

class EmailController extends Controller {

    private $viewData;
    private $message = array('success' => true, 'error' => array());
    private $validator;
    private $OrganizerModel;
    private $EmailModel;

    public function init() {

        /* @var $validator FormValidator */
        $this->validator = new FormValidator();

        /* @var $OrganizerModel OrganizerModel */
        $this->OrganizerModel = new OrganizerModel();
        
        /* @var $EmailModel EmailModel */
        $this->EmailModel = new EmailModel();
    }

    public function actionIndex($p = 1) {

        $this->CheckPermission();

        $ppp = Yii::app()->getParams()->itemAt('ppp');
        $s = isset($_GET['s']) ? $_GET['s'] : "";
        $s = strlen($s) > 2 ? $s : "";

        $emails = $this->EmailModel->gets();
        $total = $this->EmailModel->counts();

        $this->viewData['emails'] = $emails;
        $this->viewData['total'] = $total;        

        $this->render('index', $this->viewData);
    }

    public function actionEdit($id = "") {
        $this->CheckPermission();
        $email = $this->EmailModel->get($id);
        if (!$email)
            $this->load_404();
        if ($_POST)
            $this->do_edit($email);

        $this->viewData['message'] = $this->message;
        $this->viewData['email'] = $email;
        $this->render('edit', $this->viewData);
    }

    private function do_edit($email) {
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);

        if ($this->validator->is_empty_string($title))
            $this->message['error'][] = "Please enter title.";        

        if (count($this->message['error'])) {
            $this->message['success'] = false;
            return false;
        }

        $this->EmailModel->update(array('title' => $title, 'content' => $content, 'id' => $email['id']));
        HelperGlobal::add_log(UserControl::getId(), $this->controllerID(), $this->methodID(), array('Action' => 'Edit', 'Old data' => $email, 'New data' => $_POST));
        $this->redirect(Yii::app()->request->baseUrl . "/email/edit/id/$email[id]/?s=1");
    }
    
}