<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST ");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database-conn.php';

include_once '../objects/image.php';

$db = new Database;
$dbPath = $db->file;

$image = new Image($dbPath);



if(
    !empty($_FILES['image']['name']) &&
    !empty($_FILES['image']['tmp_name']) &&
    !empty($_POST['user_id'])
  )
  {
      $image->image_file = $_FILES['image'];
      $image ->user_id = $_POST['user_id'];

      if($image->create())
      {
        http_response_code(201);

        echo json_encode(['message'=>'image uploaded']);
      }
      else
      {
        http_response_code(503);

        echo json_encode(['message'=>'Unable to upload image']);
      }
   
  }
  else
  {
    http_response_code(400);

    echo json_encode(['message'=>'Unprocessable Data information']);
  }