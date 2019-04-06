<?php
    $img_dir = "images/"; /*Uploads image into this folder*/
    $img_file = $img_dir . basename($_FILES["set_file_name"]["name"]);
    $can_upload = 1;
    $img_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check_image = getimagesize($_FILES["set_file_name"]["tmp_name"]);
        if($check_image !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $can_upload = 1;
        } else {
            echo "File is not an image.";
            $can_upload = 0;
        }
    }
    // Check if file already exists
    if (file_exists($img_file)) {
        echo "Sorry, file already exists.";
        $can_upload = 0;
    }
    // Check file size
    if ($_FILES["set_file_name"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $can_upload = 0;
    }
    // Allow certain file formats
    if($img_file_type != "jpg" && $img_file_type != "png" && $img_file_type != "jpeg"
    && $img_file_type != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $can_upload = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($can_upload == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["set_file_name"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["set_file_name"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>