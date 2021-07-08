<?php

class ImageUploader{

    protected $error = '';

    protected $attribute = [
        'maxImageSize'=>5000000,
        'uploadPath'=>'upload/',
        'fileType'=>'jpg|jpeg|png|gif'
    ];

    private $image = null;

    private $imagePath = '';

    public function __construct($file){
        if(getimagesize($file['tmp_name']) !== false){
            $this->image = $file;
            $this->imagePath = basename($file['name']);
        }
        else{
            throw new Exception('File is not an Image');
        }
    }

   
    // Check if file already exists
    protected function imageExit($fullImagePath){
        if (file_exists($fullImagePath)) {
            $this->error = 'Sorry, image already exists.';
            return true;
        } 

        return false;
    }

    // Check file size
    protected function isAcceptableImageSize(){
        if(!is_null($this->image)){
            if($this->image['size'] > $this->attribute['maxImageSize']){
                $this->error = 'Sorry, your image is too large.';
                return false;
            }
        }

        return true;
    }

    // Allow certain file formats
    protected function isAcceptableImageType($fileType){
        if(in_array($fileType,explode('|',$this->attribute['fileType']))){
            return true;
        }

        $type = $this->attribute['fileType'];
        $this->error = "Sorry, only $type files are allowed.";
        return false;
    }

    protected function validateImage(){
        $imageExtension = strtolower(
            pathinfo($this->imagePath,PATHINFO_EXTENSION)
        );

        if(
            $this->isAcceptableImageType($imageExtension) &&
            $this->isAcceptableImageSize()
          ){
              return true;
          }

          return false;
    }

    public function upload(){
        $uploadResult = [];
        if ($this->validateImage()) {
            $newImagePath = str_shuffle(rand(10,1000000)).'_'.
                $this->imagePath;
            $imageFullPath = $this->attribute['uploadPath'].
                $newImagePath;
            
            if(!$this->imageExit($imageFullPath)){
                // if everything is ok, try to upload file
                if (move_uploaded_file($this->image['tmp_name'], $imageFullPath)) {
                    $uploadResult['savePath'] = $newImagePath;
                } else {
                    $this->error = 'Sorry, there was an error uploading your image.';
                }
            }
        }

        $uploadResult['error'] = $this->error;

        return $uploadResult;
    }

    public function __set($key, $value){   
        if(!in_array($key,['maxImageSize','uploadPath','fileType'])){
            throw new Exception('Invalid property');
        }

        if($key == 'uploadPath'){
           $value = strpos(strrev($value),'/') !== 0 
               ? $value.'/':$value;
        }

        $this->attribute[$key] = $value;
    }
}
?>