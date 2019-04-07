<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Image Uploader</title>
    </head>
    <body>
        <form action="upload_api_v2.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image">
            <button type="submit" name="upload">Upload Image</button>
        </form>
    </body>
</html>