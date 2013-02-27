<?php

class Helper {

    public static function image_types($type) {
        $image_type = array('image/png' => 'png', 'image/jpeg' => 'jpg', 'image/gif' => 'gif');
        return $image_type[$type];
    }

    public static function print_error($message) {
        $html = "";
        if ($message['success'] == false) {
            $html.= '<div class="alert alert-error">';
            $html.='<button type = "button" class = "close" data-dismiss = "alert">×</button>';
            $html.='<h4>Error!</h4>';
            foreach ($message['error'] as $e)
                $html.= $e . "<br/>";
            $html.= '</div>';
        }
        return $html;
    }

    public static function print_success($message = array()) {
        if (isset($message['success']) && !$message['success'])
            return "";
        $html = "";
        if ((isset($_GET['s']) && $_GET['s'] == 1)) {
            $message = isset($_GET['msg']) ? $_GET['msg'] : "Update successful.";
            $html.= '<div class="alert alert-success">';
            $html.='<button type = "button" class = "close" data-dismiss = "alert">×</button>';
            $html.='<h4>Success!</h4>';
            $html.= $message;
            $html.= '</div>';
        }
        return $html;
    }

    public static function string_truncate($string, $your_desired_width = 50) {
        $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
        $parts_count = count($parts);

        $length = 0;
        $last_part = 0;
        for (; $last_part < $parts_count; ++$last_part) {
            $length += strlen($parts[$last_part]);
            if ($length > $your_desired_width) {
                break;
            }
        }

        return $length > $your_desired_width ? implode(array_slice($parts, 0, $last_part)) . " ..." : implode(array_slice($parts, 0, $last_part));
    }

    public static function get_first_paragraph($string, $length = 200) {
        preg_match("/<p>(.*)<\/p>/", $string, $matches);
        if (!$matches)
            return self::string_truncate($string, $length);
        $intro = strip_tags($matches[1]); //removes anchors and other tags from the intro
        return $intro;
    }

    public static function remove_accents($title) {
        $replacement = '-';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');

        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            //'/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        $title = urldecode($title);

        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $title));
    }

    public static function create_slug($str) {
        $str = self::remove_accents($str);
        return preg_replace("/[^a-zA-Z0-9\.]/", "-", $str);
    }

    public static function _lang($key) {
        
        $lang = HelperApp::get_cookie('lang');
        
        if (!$lang)
        {
            HelperApp::add_cookie('lang', 'vn', true);
            $lang = Yii::app()->getParams()->itemAt('lang');
        } 
        
        $data = array('vn' => array('username' => 'Tài khoản',
                                    'password' => 'Mật khẩu'
                    ),
                    'en' => array('username' => 'Username',
                                'password' => 'Password'));
        return isset($data[$lang][$key]) ? $data[$lang][$key] : $key;
    }
    
    public static function category_types(){
        return array('faq'=>'Faq','event'=>'Event');
    }
    
    public static function cities(){
        return array('Hồ Chí Minh',
                    'Hà Nội',
                    'Đà Nẵng',
                    'Huế',
                    'Nha Trang',
                    'Đà Lạt');
    }
    
    public static function ticket_types(){
        return array('free'=>'Miễn phí','paid'=>'Tính phí');
    }
    
    public static function ticket_status(){
        return array(1=>'On Sale',0=>'Hide');
    }
}