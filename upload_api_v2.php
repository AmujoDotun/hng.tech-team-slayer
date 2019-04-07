<?php
require_once 'api-v2/ImageUploader.php';

if(isset($_POST['upload'])){
    try{
        $imageUploader = new ImageUploader($_FILES['image']);
        $imageUploader->uploadPath = 'images/';
        $imageUploader->fileType = 'jpg|png';
        $uploadResult = $imageUploader->upload();
        echo json_encode($uploadResult);
       
    }catch(Exception $e){
        echo json_encode(['error'=>$e->getMessage()]);
    }
 }

 //Use this if .md file is require for image upload

//  if(isset($_POST['upload'])){
//     //print_r($_FILES['image']);
//     try{
        
//         $fileHandler = fopen("upload.md", "a") or die("Unable to open file!");
//         $imageUploader = new ImageUploader($_FILES['image']);
//         $imageUploader->uploadPath = 'images/';
//         $result = $imageUploader->upload();
//         if($result['error'] == ''){
//             fwrite($fileHandler,$result['savePath']."\n");
//             fclose($fileHandler);
//             echo json_encode($result);
//         }else{
//             echo json_encode($result);
//         }
//     }catch(Exception $e){
//         echo json_encode(['error'=>$e->getMessage()]);
//     }
//  }

?>