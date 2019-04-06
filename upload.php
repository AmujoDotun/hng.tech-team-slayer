<?php
        $errors = [];
		$allowed = array('png','jpg','jpeg','gif');
        $avatar = $name = $_FILES['avatar']['name'];
        $nameArray = explode('.',$name);
        $fileName = $nameArray[0];
        $fileExt = $nameArray[1];
        $mime = explode('/',$_FILES['avatar']['type']);
        $mimeType = $mime[0];
        $mimeExt = $mime[1];
        $tmp = $_FILES['avatar']['tmp_name'];
        $fileSize = $_FILES['avatar']['size'];
        if($mimeType != 'image') {
         	$errors[] = 'The file must be an image';
         }
         if(!in_array($fileExt, $allowed)) {
         	$errors[] = 'The file extension must be a png, jpg, jpeg or gif file';
          }
          if($fileSize > 10000000) {
          	$errors[] = 'The file size must be under 10mb';
           }
           if(empty($errors)){
            //Upload File and Insert Into markdown
            move_uploaded_file($tmp, 'img/'.$name);
            //markdown code missing as no clear structure has been provided for data storage in markdown files
        	}
?>
	
<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Image Upload!</title>
  </head>
  <body>
  	<div class="col-md-6 col-md-offset-3">
    	<form action="" method="post" enctype="multipart/form-data">
    		<p class="text-danger"></p>
    		<div class="custom-file">
  			<input type="file" name="avatar" class="custom-file-input" id="customFile">
  			<label class="custom-file-label" for="customFile">Choose file</label>
			</div>
			 <button class="btn btn-primary" type="submit">Submit form</button>
    	</form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>