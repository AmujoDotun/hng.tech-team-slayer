<?php
require_once "vendor/autoload.php";

session_start();
$image = 'image';
if (isset($_FILES[$image])) {

    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds 2MB',
        2 => 'The uploaded file exceeds 2MB',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write to disk',
        8 => 'A PHP extension stopped the file upload.'
    );

    $ext_error = false;
    $extensions = array('jpg', 'jpeg', 'gif', 'png');
    $file_ext = explode('.', $_FILES[$image]['name']);
    $file_ext = strtolower(end($file_ext));
    if (!in_array($file_ext, $extensions)) {
        $ext_error = true;
    }

    $result = 'result';
    $_SESSION[$result] = "";

    //if error of the upload is not equal to 0 
    if ($_FILES[$image]['error']) {
        echo $phpFileUploadErrors[$_FILES[$image]['error']];
    } elseif ($ext_error) {
        echo "File format not allowed!";
    } else {
        $new_file_name = uniqid('', true).".".$file_ext;
        move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/' . $new_file_name);

        /**
         * Save images on a cloudinary
         */
        // if (file_exists('settings.php')) {
        //     include 'settings.php';
        // }

        // $image_path = '/uploads/'.$new_file_name;
        // $arr_result = \Cloudinary\Uploader::upload(__DIR__.$image_path);
        // if(!$arr_result){
        //    echo "Image wasn't uploaded successfully!";
        // }
        // $_SESSION['image_url'] = $arr_result['secure_url'];
        // header('Location: index.php');
        echo "Image upload was successful";
    }

    
}
