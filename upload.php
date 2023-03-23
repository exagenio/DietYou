<form action="upload.php" method="post" enctype="multipart/form-data">
  <input type="file" name="image" id="image">
  <input type="submit" name="submit" value="Upload Image">
</form>
<?php
if(isset($_POST['submit'])){
    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = strtolower(end(explode('.',$fileName)));
    $allowed = array('jpg','jpeg','png','gif');

    if(in_array($fileExt,$allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = uniqid('',true).".".$fileExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);
                echo "File uploaded successfully!";
            }else{
                echo "File size too large.";
            }
        }else{
            echo "There was an error uploading the file.";
        }
    }else{
        echo "You cannot upload files of this type.";
    }
}
?>