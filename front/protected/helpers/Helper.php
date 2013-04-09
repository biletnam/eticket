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
            $message = isset($_GET['msg']) ? $_GET['msg'] : "Update successfully.";
            $html.= '<div class="alert alert-success">';
            $html.='<button type = "button" class = "close" data-dismiss = "alert">×</button>';
            $html.='<h4>Congratulations!</h4>';
            $html.= $message;
            $html.= '</div>';                       
        }   
        return $html;
    }
    
    public static function print_info($message = array()) {
        if (isset($message['success']) && !$message['success'])
            return "";
        $html = "";     
        if ((isset($_GET['iok']) && $_GET['iok'] == 1)) {
            $message = isset($_GET['msg']) ? $_GET['msg'] : "Information.";
            $html.= '<div class="alert alert-info">';
            $html.='<button type = "button" class = "close" data-dismiss = "alert">×</button>';
            $html.='<h4>Note!</h4>';
            $html.= $message;
            $html.= '</div>';                       
        }   
        return $html;
    }
    
    
    public static function print_warning($message = array()) {
        if (isset($message['success']) && !$message['success'])
            return "";
        $html = "";     
        if ((isset($_GET['wok']) && $_GET['wok'] == 1)) {
            $message = isset($_GET['msg']) ? $_GET['msg'] : "Warning.";
            $html.= '<div class="alert alert-warning">';
            $html.='<button type = "button" class = "close" data-dismiss = "alert">×</button>';
            $html.='<h4>Warning!</h4>';
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

    public static function wpautop($pee, $br = 1) {

        if (trim($pee) === '')
            return '';
        $pee = $pee . "\n"; // just to make things a little easier, pad the end
        $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
        // Space things out a little
        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
        $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
        if (strpos($pee, '<object') !== false) {
            $pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
            $pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
        }
        $pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
        // make paragraphs, including one at the end
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
        $pee = '';
        foreach ($pees as $tinkle)
            $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
        $pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
        $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
        $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
        $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
        $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
        if ($br) {
            //$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);
            $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
            $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
        }
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        if (strpos($pee, '<pre') !== false)
            $pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee);
        $pee = preg_replace("|\n</p>$|", '</p>', $pee);

        return $pee;
    }

    public static function maybe_serialize($data) {
        if (is_array($data) || is_object($data))
            return serialize($data);

        if (self::is_serialized($data))
            return serialize($data);

        return $data;
    }

    public static function is_serialized($data) {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        $length = strlen($data);
        if ($length < 4)
            return false;
        if (':' !== $data[1])
            return false;
        $lastc = $data[$length - 1];
        if (';' !== $lastc && '}' !== $lastc)
            return false;
        $token = $data[0];
        switch ($token) {
            case 's' :
                if ('"' !== $data[$length - 2])
                    return false;
            case 'a' :
            case 'O' :
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b' :
            case 'i' :
            case 'd' :
                return (bool) preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
        }
        return false;
    }

    public static function create_slug($str) {
        $str = self::remove_accents($str);
        return preg_replace("/[^a-zA-Z0-9\.]/", "-", $str);
    }

    public static function get_youtube_id($youtubeUrl) {
        if (isset($youtubeUrl)) {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $youtubeUrl, $matches);
            @$youtubeUrl = $matches[1];
        }
        else
            $youtubeUrl = '';
        return $youtubeUrl;
    }

    public static function _lang($key) {

        $lang = HelperApp::get_session('lang');

        if (!$lang) {
            HelperApp::add_session('lang', 'en');
            $lang = Yii::app()->getParams()->itemAt('lang');
        }

        $data = array('vn' => array('username' => 'Tài khoản',
                'password' => 'Mật khẩu'
            ),
            'en' => array('username' => 'Username',
                'password' => 'Password'));
        return isset($data[$lang][$key]) ? $data[$lang][$key] : $key;
    }

    public static function get_browser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern,
            'shortname' => $ub
        );
    }

    public static function is_mobile() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4),$match)) {
            return $match;            
        }
        return null;
    }

    public static function _Vn_day($key) {
        $arr = array('Mon' => 'Thứ Hai',
            'Tue' => 'Thứ Ba',
            'Wed' => 'Thứ Tư',
            'Thu' => 'Thứ Năm',
            'Fri' => 'Thứ Sáu',
            'Sat' => 'Thứ Bảy',
            'Sun' => 'Chủ Nhật');
        return isset($arr[$key]) ? $arr[$key] : $key;
    }

    public static function _Vn_meridiem($key) {
        $arr = array('am' => 'Sáng', 'pm' => 'Tối');
        return isset($arr[$key]) ? $arr[$key] : $key;
    }

    public static function _Vn_month($key) {
        $arr = array('1' => 'Tháng một',
            '2' => 'Tháng hai');
    }

    public static function category_types() {
        return array('faq' => 'Faq', 'event' => 'Sự kiện');
    }

    public static function countries() {
        $CountryModel = new CountryModel();
        return $CountryModel->gets_all_countries();
    }

    public static function ticket_types() {
        return array('free' => 'Free', 'paid' => 'Paid');
    }

    public static function _types($key) {
        $types = self::ticket_types();
        return isset($types[$key]) ? $types[$key] : $key;
    }

    public static function ticket_status() {
        return array(1 => 'Sell', 0 => 'Hide');
    }

    public static function error_code() {
        $error = array(
            '401' => "You do not have permission to access this page",
            '404' => "Page not found",
            '200' => 'Successfully',
            '1' => 'You are not login',
            '2' => 'The api token does not correct',
            '3' => 'The access token does not correct',
            '4' => 'Fields do not correct'
        );

        return $error;
    }

    public static function _error_code($code) {
        $error = self::error_code();
        return isset($error[$code]) ? $error[$code] : $code;
    }
    
    public static function gen_access_token() {
        return base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()));
    }
    
    public static function get_card_types(){
        return array('Visa'=>'Visa','MasterCard'=>'MasterCard');
    }
    
    public static function _parse_id($id){
        $lenght = strlen($id);
        $final_id = str_repeat('0', 6 - $lenght) . $id;
        return $final_id;
    }

}