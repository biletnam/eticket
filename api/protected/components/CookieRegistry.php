<?php

/*
 * @@class CookieRegistry 
 * @@author thanhha.phan
 * @@example
 * $reg = new CookieRegistry(); // default name và expire time
 * $reg = new CookieRegistry('MY_REGISTRY',3600); //tên user đặt với expire time 3600 seconds
 * $reg->SetData($my_data); // save data to registry 
 * $reg->StoreData(); //luu xuogn cookie
 * $new_data = $reg->RestoreData(); //lấy data từ registry
 * 
 * @@comment 
 * tất cả việc store và restore phai duoc thuc hiện trước khi output bất cứ cái gì v�? cho user
 * nếu $data của registry là rỗng hoặc ko có phan tử
 * n1o sẽ hủy cookie
 */

class CookieRegistry {

    private $data;
    private $uniqueName;
    private $expire;
    private $cookiePath;
    //mcrypt configuration
    private $key = "E7L2l8ezb8keIH3su7m3JlUH"; // 24 bit Key
    private $iv;

    //$str = encrypt($input, $key, $iv, $bit_check);
    //echo "Start: $input - Excrypted: $str - Decrypted: " . decrypt($str, $key, $iv, $bit_check);
    //Unique name dùng để phân biệt các registry với nhau
    ///tránh xung đột với cookie có sẵn

    public function __construct($UniqueRegistryName = 'EticketFEProject', $time = 2592000, $cookiePath = '/') {
        $this->iv = base64_decode('wB3VLpOoTQVeWt04i/wagQ+zDGg0uAJdyneTUG3x8Gc=');
        $this->uniqueName = $UniqueRegistryName;
        $this->expire = time() + $time;
        $this->cookiePath = $cookiePath;
        $this->InitData();
    }

    public function setExpireTime($seconds){
        $this->expire = time() + $seconds;
    }
    
    private function InitData() {
        try {
            $this->data = $this->cookieDeSerialization();
        } catch (Exception $serializeEx) {
            $this->data = array();
        }
        //cái bug này sửa kinh quá, ghê quá >.<
        if (is_null($this->data) || count($this->data) == 0 || !is_array($this->data)) {
            $this->data = array();
        }
    }

    private function cookieSerialization() {
        if ($this->data == null || count($this->data) == 0 || !is_array($this->data)) {
            $this->data = array();
        }
        $serialized_data = base64_encode(serialize($this->data));
        $dispatch_data = array($this->str2hex($serialized_data), $this->expire, $serialized_data);
        return $this->encrypt(implode('|', $dispatch_data));
    }

    private function cookieDeSerialization() {
        if (!isset($_COOKIE[$this->uniqueName]))
            return null;
        //print_r(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
        //echo mcrypt_get_block_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_CBC);
        $messages = explode('|', $this->decrypt(@$_COOKIE[$this->uniqueName]));
        if (count($messages) != 3 || intval($messages[1]) < time() )
            return null;

        $mac = $messages[0];
        $serialized_data = $messages[2];

        //check MAC
        if ($this->str2hex($serialized_data) === $mac) {
            $data = unserialize(base64_decode($serialized_data));
            //print_r($data);
            return $data;
        } else null;
    }

    public function Add($strKey, $value) {
        if ($value == null)
            unset($this->data[$strKey]);
        else
            $this->data[$strKey] = $value;
    }

    public function Get($strKey) {
        return @$this->data[$strKey];
    }

    
    public function Save($session = false) {
        //hủy cookie
        if (is_null($this->data) || count($this->data) == 0 || !is_array($this->data)) {
            setcookie($this->uniqueName, '', time() - 36000, $this->cookiePath);
        } else {
            $hashData = $this->cookieSerialization();
            if ($session)
                $this->expire = 0;
            setcookie($this->uniqueName, $hashData, $this->expire, $this->cookiePath);
        }
    }

    public function Clear() {
        setcookie($this->uniqueName, '', time() - 36000, $this->cookiePath);
    }

    private function encrypt($text) {
        
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $text, MCRYPT_MODE_CBC, $this->iv)));
    }

    private function decrypt($text) {        
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, base64_decode($text), MCRYPT_MODE_CBC, $this->iv));
    }

    private function str2hex($text) {
        $crc = crc32($text);
        if ($crc & 0x80000000) {
            $crc ^= 0xffffffff;
            $crc += 1;
            $crc = -$crc;
        }
        return $this->int32_to_hex($crc);
    }

    private function int32_to_hex($value) {
        $value &= 0xffffffff;
        return str_pad(strtoupper(dechex($value)), 8, "0", STR_PAD_LEFT);
    }

}