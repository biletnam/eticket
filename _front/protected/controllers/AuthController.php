<?php

class AuthController extends Controller {

    public function actions() {
        
    }

    public function actionIndex() {
        
    }

    public function actionSignin() {
        $this->render('signin');
    }

    private function validate() {
        $message = '';
        if ($_POST['email'] == '') {
            $msg[] = 'Please enter your email.';
        }
        // checking whether valid email
        $regexp = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
        if (!preg_match($regexp, $_POST['email'])) {
            $msg[] = 'Please enter a valid email address.';
        }

        if ($_POST['password'] == '') {
            $msg[] = 'Please enter your password.';
        }
        // checking whether valid password
        $regexp = "/^[a-z0-9_-]{6,18}$/";
        if (!preg_match($regexp, $_POST['password'])) {
            $msg[] = 'Password invalid';
            $msg[] = 'Your password must be at least 4 characters and smaller than 18 characters. Please try again.';
        }
        if (isset($msg))
            $message = implode('<br/>', $msg);
        return $message;
    }

    private function post_item() {
        if (isset($_POST['email'])) {
            $post->email = $_POST['email'];
            $post->password = $_POST['password'];
            return $post;
        }
    }

    public function actionLogin() {
        $user = new UserModel();
        if (isset($_POST['email'])) {
            $message = $this->validate();
            if ($message == '') {
                $email = $_POST['email'];
                $pass = md5($_POST['password']);
                $login_user = $user->checking_login($email, $pass);
                if (count($login_user) > 0) {
                    $this->redirect(Yii::app()->request->baseUrl);
                } else {
                    $item = $this->post_item();
                    $notification = 'Invalid email and/or password. Please try again.';
                    $this->render('signin', array('notification' => $notification, 'item' => $item));
                }
            } else {
                $item = $this->post_item();
                $this->render('signin', array('notification' => $message, 'item' => $item));
            }
        } else {
            $this->render('signin');
        }
    } //

    public function actionRegister() {
        $user = new UserModel();
        if (isset($_POST['email'])) {
            $message = $this->validate();
            if ($message == '') {
                $email = $_POST['email'];
                $pass = md5($_POST['password']);
                $user->register_user($email, $pass);
            } else {
                $item = $this->post_item();
                $this->render('signin', array('notification' => $message, 'item' => $item));
            }
        } else {
            $this->render('signup');
        }
    }

}