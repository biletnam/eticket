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
            $msg[] = 'Email không được để trống';
        }
        // checking whether valid email
        $regexp = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
        if (!preg_match($regexp, $_POST['email'])) {
            $msg[] = 'Email không hợp lệ';
        }

        if ($_POST['password'] == '') {
            $msg[] = 'Mật khẩu không được để trống';
        }
        // checking whether valid password
        $regexp = "/^[a-z0-9_-]{6,18}$/";
        if (!preg_match($regexp, $_POST['password'])) {
            $msg[] = 'Mật khẩu không hợp lệ';
            $msg[] = 'Mật khẩu phải có ít nhất 6 ký tự và nhiều nhất là 18 ký tự';
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
                    $notification = 'Tài khoản hoặc Mật khẩu của bạn chưa chính xác. Bạn vui lòng đăng nhập lại. ';
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