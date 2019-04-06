<?php

require 'FileUploader.php';
require 'utils.php';




if($_SERVER["REQUEST_METHOD"]=="POST"){




    try {
        $fileUploader = new FileUploader("image");


        $fileUploader->setAllowedFileTypes(["jpg","png","jpeg","svg"]);
        $fileUploader->setMaxFileSize(5000000);


        if($fileUploader->uploadFile()){



            $data["status"] = "success";
            $data["data"] =$data;

            success(["message"=>"File Uploaded successfully"]);
        }else{
            error("An error occurred file was not uploaded");
        }
    } catch (Exception $e) {

        error($e->getMessage());
    }
}else{

    error("Only Post Request is allowed");
}




