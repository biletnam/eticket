<?php

/**
 * Provide simple Upload File Handler
 * @access public
 * @author HaPhan
 * @version 0.1
 */
class UploadHandler {

    protected $uploadName;
    protected $uploadedItems = array();
    protected $singleFileUpload = false;
    protected $allowedType = array('image/png', 'image/jpeg','image/gif');
    protected $allowedMedia = array('audio/mpeg');
    protected $allowedSize = 6291456;

    //protected $allowedSize = 500000;
    /**
     * Simple Upload File Handler
     * @var string $uploadName
     */
    public function __construct($uploadName, $singleFileUpload = false) {
        $this->uploadName = $uploadName;
        $this->singleFileUpload = $singleFileUpload;
    }

    /**
     * Get uploaded files and informations
     * @return array
     */
    public function getUploadedItems() {
        $this->_processUpload($this->uploadName);
        //var_dump($this->uploadedItems);
        if (count($this->uploadedItems) > 0)
            return $this->uploadedItems;
        else
            return false;
    }

    public function getUploadedItemsCustomDes($cusdes) {
        $this->_processUpload_CustomDestination($this->uploadName, $cusdes);
        //var_dump($this->uploadedItems);
        if (count($this->uploadedItems) > 0)
            return $this->uploadedItems;
        else
            return false;
    }

    public function getUploadedMp3Items() {
        $this->_processUploadMp3($this->uploadName);
        //var_dump($this->uploadedItems);
        if (count($this->uploadedItems) > 0)
            return $this->uploadedItems;
        else
            return false;
    }

    private function _safeFileName($filename) {
        return preg_replace("/[^a-zA-Z0-9\.]/", "_", $filename);
    }

    private function validateMediaType($type) {
        if (array_search($type, $this->allowedMedia) === false)
            return false;
        else
            return true;
    }

    private function validateType($type) {
        if (array_search($type, $this->allowedType) === false)
            return false;
        else
            return true;
    }

    private function validateImage($image) {
        if (is_array(getimagesize($image)))
            return true;
        return false;
    }

    private function validateSize($size) {
        if ((float) $size > $this->allowedSize)
            return false;
        return true;
    }

    private function _processUploadMp3($upload_name) {
        $count = count($_FILES[$upload_name]['name']);
        if ($count <= 0)
            return;
        $config = App::$config;
        if ($count == 1) {
            $pathinfo = pathinfo($_FILES[$upload_name]['name']);
            $savedName = Ultilities::random('alpha') . '.' . $pathinfo['extension'];
            $dest = $config['upload_dir'] . $savedName;
            try {
                $size = $_FILES[$upload_name]['size'];
                $type = $_FILES[$upload_name]['type'];
                if (!$this->validateMediaType($type)) {
                    //echo 'fail!';
                    return false;
                }

                move_uploaded_file($_FILES[$upload_name]['tmp_name'], $dest);
                $newFile = array('name' => $savedName, 'size' => $size, 'type' => $type);
                //var_dump($newFile);
                array_push($this->uploadedItems, $newFile);
            } catch (Exception $er) {
                echo $er->getMessage();
            }
        }else
            for ($i = 0; $i < $count; $i++) {
                $pathinfo = pathinfo($_FILES[$upload_name]['name']);
                $savedName = Ultilities::random('alpha') . '.' . $pathinfo['extension'];
                $dest = $config['upload_dir'] . $savedName;
                try {

                    $size = $_FILES[$upload_name]['size'][$i];
                    $type = $_FILES[$upload_name]['type'][$i];
                    if (!$this->validateMediaType($type)) {
                        //echo 'fail!';
                        return false;
                    }
                    move_uploaded_file($_FILES[$upload_name]['tmp_name'][$i], $dest);
                    $newFile = array('name' => $savedName, 'size' => $size, 'type' => $type);
                    //var_dump($newFile);
                    array_push($this->uploadedItems, $newFile);
                } catch (Exception $er) {
                    echo $er->getMessage();
                }
            }
    }

    private function _processUpload($upload_name) {
        //print_r($_FILES[$upload_name]);
        $count = count($_FILES[$upload_name]['name']);
        if ($count <= 0)
            return;
        $config = App::$config;
        if ($count == 1) {
            $pathinfo = pathinfo($_FILES[$upload_name]['name']);
            $savedName = Ultilities::random('alpha') . '.' . $pathinfo['extension'];
            $dest = $config['upload_dir'] . $savedName;
            try {
                $size = $_FILES[$upload_name]['size'];
                $type = $_FILES[$upload_name]['type'];
                $image = $_FILES[$upload_name]['tmp_name'];                
                //echo $size;
                //check file type
                if (!$this->validateImage($image) || !$this->validateType($type) || !$this->validateSize($size)) {
                    
                    return false;
                }
                move_uploaded_file($_FILES[$upload_name]['tmp_name'], $dest);
                $newFile = array('name' => $savedName, 'size' => $size, 'type' => $type);
                //var_dump($newFile);
                array_push($this->uploadedItems, $newFile);
            } catch (Exception $er) {
                echo $er->getMessage();
            }
        }else
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES[$upload_name]['name'][$i] != "") {
                    $pathinfo = pathinfo($_FILES[$upload_name]['name'][$i]);
                    $savedName = Ultilities::random('alpha') . '.' . $pathinfo['extension'];
                    $dest = $config['upload_dir'] . $savedName;
                    try {

                        $size = $_FILES[$upload_name]['size'][$i];
                        $type = $_FILES[$upload_name]['type'][$i];
                        $image = $_FILES[$upload_name]['tmp_name'][$i];
                        //check file type
                        if (!$this->validateImage($image) || !$this->validateType($type) || !$this->validateSize($size)) {
                            return false;
                        }

                        move_uploaded_file($_FILES[$upload_name]['tmp_name'][$i], $dest);
                        $newFile = array('name' => $savedName, 'size' => $size, 'type' => $type);
                        //var_dump($newFile);
                        array_push($this->uploadedItems, $newFile);
                    } catch (Exception $er) {
                        echo $er->getMessage();
                    }
                }
            }
    }

    private function _processUpload_CustomDestination($upload_name, $cusdes = "") {
        $count = count($_FILES[$upload_name]['name']);
        if ($count <= 0)
            return;
        $config = App::$config;
        if ($count == 1) {
            $pathinfo = pathinfo($_FILES[$upload_name]['name']);
            $savedName = Ultilities::random('alpha') . '.' . $pathinfo['extension'];
            $dest = $cusdes . $savedName;
            try {
                $size = $_FILES[$upload_name]['size'];
                $type = $_FILES[$upload_name]['type'];
                $image = $_FILES[$upload_name]['tmp_name'];

                //echo $size;
                //check file type
                if (!$this->validateImage($image) || !$this->validateType($type) || !$this->validateSize($size)) {
                    //echo 'fail!';
                    return false;
                }
                move_uploaded_file($_FILES[$upload_name]['tmp_name'], $dest);
                $newFile = array('name' => $savedName, 'size' => $size, 'type' => $type);
                //var_dump($newFile);
                array_push($this->uploadedItems, $newFile);
            } catch (Exception $er) {
                echo $er->getMessage();
            }
        }else
            for ($i = 0; $i < $count; $i++) {
                $pathinfo = pathinfo($_FILES[$upload_name]['name']);
                $savedName = Ultilities::random('alpha') . '.' . $pathinfo['extension'];
                $dest = $cusdes . $savedName;
                try {

                    $size = $_FILES[$upload_name]['size'][$i];
                    $type = $_FILES[$upload_name]['type'][$i];
                    $image = $_FILES[$upload_name]['tmp_name'][$i];
                    //check file type
                    if (!$this->validateImage($image) || !$this->validateType($type) || !$this->validateSize($size)) {
                        return false;
                    }

                    move_uploaded_file($_FILES[$upload_name]['tmp_name'][$i], $dest);
                    $newFile = array('name' => $savedName, 'size' => $size, 'type' => $type);
                    //var_dump($newFile);
                    array_push($this->uploadedItems, $newFile);
                } catch (Exception $er) {
                    echo $er->getMessage();
                }
            }
    }

}