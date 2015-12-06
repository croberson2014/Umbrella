<?php 
@SESSION_START(); 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
}  
/*if(!$_SESSION['registration'] == true){
	header("Location: ../HomePage.php");
}*/
?>
<html> 
<!--
	Name: newuser.php
	Path: Root/project2/automate/newuser.php
	Version: 1
	Function : This form is used to decouple any additional new user operations from 
	from form validation operations. 
-->
<head> 
<meta lang='en'></meta>
<link rel='stylesheet' href='../Homepage.css'>
</head> 
<body>
<?php 
	require("header.php"); 
?> 
<div>
<?php
	require("user.php"); 
	require("validate.php"); 
	//validate is not universal  
?> 
</div>
<?php 
	require("footer.php"); 
?> 
</body> 
</html> 