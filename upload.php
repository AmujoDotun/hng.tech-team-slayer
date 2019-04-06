<?php


if(isset($_POST['submit'])) {
    // get all info from file
    $file = $_FILES['image'];
    // print_r($file);
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    // get extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // define allowed extensions
    $allowed = array('jpg', 'jpeg', 'png');

    if(in_array($fileActualExt, $allowed)) {
        // check for error
        if($fileError === 0) {
            // 5mb limit
            if($fileSize < 5000000) {
                // rename image file
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: index.php?uploadsuccess");
            } else {
                echo "Your image is too big!";
            }
        } else {
            echo "There was an error uploading this file!";
        }
    } else {
        echo "Image format not allowed!";
    }
}




?>