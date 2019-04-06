<?php


define('SERVER', '');
define('USER', '');
define('PASSWORD', '');
define('DB', '');

// connection setup
$mysql = new mysqli(SERVER, USER, PASSWORD, DB);

// json response
$response = array();



if ($mysql->connect_error) {
    $response['MESSAGE'] = 'Error in Server';
    $response['STATUS'] = 500;
} else {


    if (is_uploaded_file($_FILES['user_image']['tmp_name']) && $_POST['user_name']) {
        $tmp_file = $_FILES['user_image']['tmp_name'];
        $img_name = $_FILES['user_image']['name'];
        $uniqueName = time() . $img_name;
        $upload_dir = './images/' . $uniqueName;

        $imageFileType = pathinfo($upload_dir, PATHINFO_EXTENSION);

        // Allowed image formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $response['MESSAGE'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            $response['STATUS'] = 400;
        } else {

            $sql = "INSERT INTO tbl_users(user_name, user_profile) VALUES ('{$_POST["user_name"]}', '{$uniqueName}')";

            if (move_uploaded_file($tmp_file, $upload_dir) && $mysql->query($sql)) {

                echo  $response['MESSAGE'] = "SUCCESSFULLY UPLOADED";
                echo $response['STATUS'] = 200;
            } else {
                $response['MESSAGE'] = 'UPLOAD FAILED';
                $response['STATUS'] = 404;
            }
        }
    } else {
        $response['MESSAGE'] = 'INVALID REQUEST';
        $response['STATUS'] = 400;
    }
}


echo json_encode($response);
