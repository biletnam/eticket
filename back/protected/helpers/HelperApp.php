<?php

class HelperApp {

    public static function get_category_sizes() {
        $array = array(
            'thumbnail' => array('w' => 260, 'h' => 140, 'crop' => true),
            'small' => array('w' => 50, 'h' => 50, 'crop' => true)
        );
        return $array;
    }

      
    public static function get_event_sizes() {
        $array = array(
            'thumbnail' => array('w' => 277, 'h' => 140, 'crop' => true),
            'small' => array('w' => 63, 'h' => 58, 'crop' => true),
            'edit' => array('w' => 97, 'h' => 94, 'crop' => true),
            'home_thumbnail' => array('w' => 80, 'h' => 80, 'crop' => true),
            'profile' => array('w' => 96, 'h' => 84, 'crop' => true)
        );
        return $array;
    }
    
     public static function get_gallery_sizes() {
        $array = array(
            'thumbnail' => array('w' => 300, 'h' => 300, 'crop' => true),
            'small' => array('w' => 100, 'h' => 100, 'crop' => true)
        );
        return $array;
    }
    
    public static function get_avatar_sizes() {
        $array = array(            
            'thumbnail' => array('w' => 300, 'h' => 300, 'crop' => true),
            'small' => array('w' => 100, 'h' => 100, 'crop' => true),
            'mini' => array('w' => 50, 'h' => 50, 'crop' => true)
        );
        return $array;        
    }
    public static function get_organizer_sizes() {
        $array = array(            
            'thumbnail' => array('w' => 300, 'h' => 300, 'crop' => true),
            'small' => array('w' => 100, 'h' => 100, 'crop' => true),
            'mini' => array('w' => 50, 'h' => 50, 'crop' => true)
        );
        return $array;        
    } 
    public static function get_slider_sizes() {
        $array = array(            
            'thumbnail' => array('w' => 300, 'h' => 300, 'crop' => true),
            'small' => array('w' => 100, 'h' => 100, 'crop' => true),
            'mini' => array('w' => 50, 'h' => 50, 'crop' => true),
            'homepage' => array('w' => 1500, 'h' => 350, 'crop' => true)
        );
        return $array;        
    } 

    public static function add_cookie($name, $value, $is_session = false, $timeout = 2592000) {
        $cookie = new CookieRegistry();
        $cookie->Add($name, $value);
        if (!$is_session)
            $cookie->setExpireTime($timeout);
        $cookie->Save($is_session);
    }

    public static function get_cookie($name) {
        $cookie = new CookieRegistry();
        return $cookie->Get($name);
    }

    public static function do_resize($remote_url, $sizes, $filename, $upload_dir, $old_filename = '') {

        $data = array();
        $img = new SimpleImage();
        $img->load($remote_url);
        self::make_folder($upload_dir);
        if ($old_filename)
            @unlink($upload_dir . $old_filename);
        $filepath = $upload_dir . $filename;
        $width = $img->getWidth();
        $height = $img->getHeight();
        $img->resizeToThumb($width, $height);
        $img->save_with_default_imagetype($filepath);

        foreach ($sizes as $size_name => $size) {
            $img->load($filepath);

            if ($size['w'] == 0) {
                $new_filename = $size['h'] . 'h-' . $filename;
                if ($old_filename)
                    $new_oldfilename = $size['h'] . 'h-' . $old_filename;
            }
            elseif ($size['h'] == 0) {
                $new_filename = $size['w'] . 'w-' . $filename;
                if ($old_filename)
                    $new_oldfilename = $size['w'] . 'w-' . $old_filename;
            }
            else {
                $new_filename = $size['w'] . 'x' . $size['h'] . '-' . $filename;
                if ($old_filename)
                    $new_oldfilename = $size['w'] . 'x' . $size['h'] . '-' . $old_filename;
            }
            $folder = str_replace(Yii::app()->getParams()->itemAt('upload_dir') . "media/", '', $upload_dir);

            $new_size = '';
            if ($size['w'] == 0) {
                if ($height > $size['h'])
                    $new_size = $img->resizeToHeight($size['h']);
            }
            elseif ($size['h'] == 0) {
                if ($width > $size['w'])
                    $new_size = $img->resizeToWidth($size['w']);
            }
            else {
                if ($height >= $size['h'] && $width >= $size['w'])
                    $new_size = $img->resizeToThumb($size['w'], $size['h']);
            }

            if ($new_size) {
                if ($old_filename)
                    @unlink($upload_dir . $new_oldfilename);
                $img->save_with_default_imagetype($upload_dir . '/' . $new_filename);
                $data[$size_name] = array(
                    'folder' => $folder,
                    'filename' => $new_filename,
                    'width' => $new_size['w'],
                    'height' => $new_size['h']
                );
            }
        }

        $data['full'] = array(
            'folder' => $folder,
            'filename' => $filename,
            'width' => $width,
            'height' => $height
        );
        return $data;
    }

    public static function make_folder($folderpath) {
        @mkdir($folderpath, 0777, true);
        @chmod($folderpath, 0777);
        // chmod parent folder
        $folder = pathinfo($folderpath);
        @chmod($folder['dirname'], 0777);
    }

    public static function get_thumbnail($sizes, $size = 'thumbnail') {
        $sizes = unserialize($sizes);
        if (isset($sizes[$size]['filename']))
            return Yii::app()->getParams()->itemAt('upload_url') . "media/" . $sizes[$size]['folder'] . '/' . $sizes[$size]['filename'];
        return Yii::app()->request->baseUrl . "/img/default.png";
    }

    public static function get_paging($ppp, $link_server, $total, $current_page) {
        $p = new Paginator();
        $p->items_per_page = $ppp;
        $p->current_page = $current_page;
        $p->link_server = $link_server;
        $p->items_total = $total;
        $p->paginate();
        return $p->display_pages();
    }

    public static function resize_images($file, $sizes, $old_name = '') {
        $image_info = getimagesize($file['tmp_name']);

        $img = Ultilities::base32UUID() . "." . Helper::image_types($image_info['mime']);
        $upload_dir = Yii::app()->getParams()->itemAt('upload_dir') . "media/" . date('Y') . '/' . date('m') . '/';
        $thumbnail = serialize(self::do_resize($file['tmp_name'], $sizes, $img, $upload_dir, $old_name));
        return array('img' => $img, 'thumbnail' => $thumbnail);
    }

    public static function email($to, $subject, $message, $footer = true, $from = 'info@eticket.com') {
        $header =
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8\r\n" .
                "From: Soinsale.com <$from>\r\n" .
                "Reply-to: $from" .
                "Date: " . date("r") . "\r\n";

        @mail($to, $subject, $message, $header);
    }

}
