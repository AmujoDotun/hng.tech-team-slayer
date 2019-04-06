<?php 
    $fopen = fopen('images.md','a');

    if(isset($_POST['uploadBtn']))
    {
        if(!empty($_FILES['img_file']['name']))
        {
            if(getImageSize($_FILES['img_file']['tmp_name']))
            {
                $checkifFileExists = file_get_contents('images.md');
                if(!empty($checkifFileExists))
                {
                    
                    $new=(array)json_decode($checkifFileExists);
                    
                    // $count = count($new) + 1;
                    
                    
                    $FileName=$_FILES['img_file']['name'];
                    if(toCheckIfImageAlreadyExists($new,$_FILES['img_file']['name']))
                    {
                        $rand = str_shuffle(rand(10,10000000));
                        $imageArray = explode('.',$_FILES['img_file']['name']); 
                        $imgExt = end($imageArray);
                        $FileName = $imageArray[0].'-'.$rand.'.'.$imgExt;
                    }

                    if(move_uploaded_file($_FILES['img_file']['tmp_name'],'img/'.$FileName))
                    {
                        $count = count($new) + 1;
                        $imageFileStorage = ['user_id'=>1,'profile_image'=>$FileName];
                        $new[$count]=$imageFileStorage;
                        $jsonArray=json_encode($new);
                        $fopen = fopen('images.md','w');
                        fwrite($fopen,"$jsonArray");
                    }
                    
                }
                else
                {
                    if(move_uploaded_file($_FILES['img_file']['tmp_name'],'img/'.$_FILES['img_file']['name']))
                    {
                        $emptyArr=[];
                        $imageFileStorage = ['user_id'=>1,'profile_image'=>$_FILES['img_file']['name']];
                        $emptyArr[1]=$imageFileStorage;
                        $jsonArray=json_encode($emptyArr);
                        
                        fwrite($fopen,"$jsonArray");
                    }
                    
                }
            }
        }
        else
        {
            echo 'No image Selected';
        }
        
    }

    function toCheckIfImageAlreadyExists($fileArr,$imageName)
    {
    foreach ($fileArr as $key)
            {
                if($key->profile_image == $imageName )
                {
                    return true;
                }
            }
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project Sub task</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="img_file">
        <input type="submit" name="uploadBtn">
    </form>
</body>
</html>