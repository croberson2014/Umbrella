<?php 
@session_start(); 
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: UserLogin.php");  } ?>
<html> 
<head> 
<title>Upload</title> 
<link rel='stylesheet' href='../HomePage.css'>
</head>
<body> 
<?php 
include('header.php');

 $target_dir = "../uploads/"; 
$target_file = $target_dir . basename($_FILES['filechoice']['name']); 
$uploadOK = 1; 
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); 
if(isset($_POST['submit'])){
	$check = getimagesize($_FILES['filechoice']['tmp_name']); 
	if($check !== false){
		echo 'File is an image - ' .$check['mime'] . '.'; 
		$uploadOK = 1; 
	}
	else{
	echo ' File is not an image.'; 
	$uploadOK = 0; 
}
}

if(file_exists($target_file)){
	echo 'Sorry, file already exists.'; 
	$uploadOK = 0; 
}

if($_FILES['filechoice']['size'] > 500000){
	echo ' File too large!'; 
	$uploadOK = 0; 
}


if($_FILES['filechoice']['error'] > 0)
{
	echo 'Problem : ';  
	switch($_FILES['filechoice']['error']){
	case 1: echo 'File upload exceeded max file size!'; break;
	case 2: echo "File exceeded max file file size!"; break; 
	case 3: echo 'File only partially uploaded'; break; 
	case 4 : echo 'No file uploaded.'; break; 
	case 6: echo 'Cannot upload file: no temp directory specified'; break; 
	case 7: echo 'Upload failed: cannot write to disk'; break; 
	default: break; 
	}
	
	$uploadOK = 0; 
}
if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' 
&& $imageFileType != 'gif' ){
	echo 'The file is not an image'; 
	$uploadOK = 0; 
}

if($uploadOK == 0){
	echo " File was not uploaded."; 
}
else{
	if(move_uploaded_file($_FILES['filechoice']['tmp_name'], $target_file)){
		echo 'The file ' . basename($_FILES['filechoice']['name']) . ' has been uploaded. ' ; 
	}
	else{
		echo 'Sorry, there was an error uploading the file. ' ; 
	}
}
include('footer.php'); 

?>
</body> 
</html> 
