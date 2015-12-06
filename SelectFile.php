<?php 
@session_start(); 
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: UserLogin.php");  } ?>
<html> 
<head> 
<link rel = 'stylesheet' href='HomePage.css'>
<style>
span{
	margin-left: auto; 
	margin-right: auto; 
	width: 90%; 
}
</style>  
</head> 
<body> 
<?php include('automate/header.php'); ?>
<form name='upload_form' action='automate/uploadFile.php' method='post' enctype='multipart/form-data'>
Attach an image: <br> 
<span>
<input type='file' name='filechoice' accept='image/jpeg, image/gif, image/jpg, image/bmp'> 
<input type='hidden' name ='MAX_FILE_SIZE' value='1000000'>
<input type='submit' value='Send File'>
</span>
</form>
<?php include('automate/footer.php'); ?>
</body> 
</html> 