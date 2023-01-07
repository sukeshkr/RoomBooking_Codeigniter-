<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image {
       protected $CI;
    function __construct()
    {
      if (!is_dir('uploads'))
      {
        mkdir('uploads', 0755, TRUE);
      }
        $this->CI =& get_instance();
    }

    public function customer_image() {

        if(!empty($_FILES)) {

            if (!is_dir('uploads/customer'))
            {
                mkdir('uploads/customer', 0755, TRUE);
            }
            
            if($_FILES['image_file']['size'] > 2020852) {

                $iJpgQuality = 10;
            }

            else if($_FILES['image_file']['size'] > 1099364) {

                $iJpgQuality = 20;
            }

            else if($_FILES['image_file']['size'] > 466668) {

                $iJpgQuality = 30;
            }
            else if($_FILES['image_file']['size'] < 466668) {

                $iJpgQuality = 40;
            }

            else{

                $iJpgQuality = 50;
            }
            
            if ($_FILES) {
                
                // if no errors and size less than 250kb

                if (!$_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 9020852) {

                    if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                        // new unique filename
                        $sTempFileName = 'uploads/customer/' . md5(time() . rand());

                        // move uploaded file into cache folder
                        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

                        // change file permission to 644
                        @chmod($sTempFileName, 0644);
                        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {

                            $aSize = getimagesize($sTempFileName); // try to obtain image info

                            if (!$aSize) {
                            @unlink($sTempFileName);
                            return;
                            }
                            // check for image type
                            switch ($aSize[2]) {
                            case IMAGETYPE_JPEG:
                            $sExt = '.jpg';
                            // create a new image from file 
                            $vImg = @imagecreatefromjpeg($sTempFileName);
                            break;
                           
                            case IMAGETYPE_PNG:
                            $sExt = '.png';
                            // create a new image from file 
                            $vImg = @imagecreatefrompng($sTempFileName);
                            break;
                            default:
                            
                            return;
                            }
                            unlink($sTempFileName);

                            $sResultFileName = $sTempFileName . $sExt;
                            
                            // output image to file
                            $crop_image = explode("/", $sResultFileName);
                            $this->image_name = $crop_image[2];
                            imagejpeg($vImg, $sResultFileName, $iJpgQuality);

                           // $this->CI->aws3->sendFile_post('onlister-upload',$sResultFileName);

                            @unlink($sTempFileName);
                        }

                    }
                }
            }

            return; 
        }

    }

   
    public function imageCropAdd() {

        $ci_name=strtolower($this->CI->router->fetch_class());

        if (!is_dir('uploads/'.$ci_name))
        {
            mkdir('uploads/'.$ci_name, 0755, TRUE);
        }

        if($ci_name=='customer')
        {
        $iWidth = 500;
        $iHeight = 320; // desired image result dimensions
        }
       
        $iJpgQuality = 90;
        if ($_FILES) {
        // if no errors and size less than 250kb
        if (!$_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 1024 * 1024) {
        if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
        // new unique filename
        $sTempFileName = 'uploads/'.$ci_name.'/' . md5(time() . rand());

        // move uploaded file into cache folder
        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
        // change file permission to 644
        @chmod($sTempFileName, 0644);
        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
        $aSize = getimagesize($sTempFileName); // try to obtain image info
        if (!$aSize) {
        @unlink($sTempFileName);
        return;
        }
        // check for image type
        switch ($aSize[2]) {
        case IMAGETYPE_JPEG:
        $sExt = '.jpg';
        // create a new image from file 
        $vImg = @imagecreatefromjpeg($sTempFileName);
        break;
        /* case IMAGETYPE_GIF:
        $sExt = '.gif';
        // create a new image from file
        $vImg = @imagecreatefromgif($sTempFileName);
        break; */
        case IMAGETYPE_PNG:
        $sExt = '.png';
        // create a new image from file 
        $vImg = @imagecreatefrompng($sTempFileName);
        break;
        default:
        @unlink($sTempFileName);
        return;
        }
        // create a new true color image
        $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);
        // copy and resize part of an image with resampling
        imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);
        // define a result image filename
        $sResultFileName = $sTempFileName . $sExt;
        // output image to file
        $crop_image = explode("/", $sResultFileName);
        $this->crop_image_name = $crop_image[2];
        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
        @unlink($sTempFileName);
        }
        }
        }
        }

        return; 
    }

}