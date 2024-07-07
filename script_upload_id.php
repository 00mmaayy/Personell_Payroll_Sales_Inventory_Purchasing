<?php
session_start();
include('connection/conn.php');
if(!isset($_SESSION['username'])){
$loc='Location: index.php?msg=requires_login '.$_SESSION['username'];
header($loc); }

$target_dir = "img/id/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) 
{
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) 
	  {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
      } 
 else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
      }
}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) 
{
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
{
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0)
{
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
}
else 
 {
	 // Check and delete file if exists.
	if (file_exists($target_file)) 
	  {
		unlink($target_file);
	  }
	 
     if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
	  { echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>"; 
        
		$username=$_SESSION['username'];
	    $trans="$target_file ID Uploaded!";
        $log_sql="insert into logbook (date,time,username,transaction) values (curdate(),curtime(),'$username','$trans')";
        $log_query=mysql_query($log_sql) or die(mysql_error());
	  } 
	else 
	  { 
        echo "Sorry, there was an error uploading your file.<br>";
	  }
 }
?>