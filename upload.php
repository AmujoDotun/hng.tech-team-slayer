<?php
    $currentDir = __DIR__;

    $uploadDirectory = "/uploads/";

    $maxFileSize = 2000000; //2MB

    $errors = [];

    $allowedFiles = ['jpeg','jpg', 'png'];

    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileTmpName  = $_FILES['file']['tmp_name'];
    $fileExtension = strtolower(end(explode('.', $fileName)));

    $fileUploadName = uniqid(true) . "." . $fileExtension;

    $uploadPath = $currentDir . $uploadDirectory . $fileUploadName;

    if (isset($_POST['submit'])) {
        if (! in_array($fileExtension, $allowedFiles)) {
            $errors[] = "This file is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > $maxFileSize) {
            $errors[] = "File should be less than " . $maxFileSize . "KB";
        }

        if (empty($errors)) {
            $uploadFile = move_uploaded_file($fileTmpName, $uploadPath);

            if ($uploadFile) {
                echo "The file upload was successful.";
                http_response_code(200);
            } else {
                echo "Something went wrong!";
                http_response_code(500);
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "You have some errors " . "\n";
            }
        }
    }
?>
