<?php 

/*
Name: logout.php
	Path: Root/project3/automate/logout.php
	Version: 1
	Function : This php script will destroy the session and unset all of the variables, and destroys the cookie. It also displays a successful logout message if the user has been logged out successfully, 
	and the opposite for a failure. 
*/
	@SESSION_START(); 
	unset($_SESSION['privilege']); 
	unset($_SESSION['loginstatus']);
	unset($_SESSION['username']); 
	$_SESSION = array(); 
	session_unset(); 
	session_destroy(); 
	setcookie('PHPSESSID', '', time() - 3600, '/', '', 0, 0);
	?>
<html> 
<head> 
<title>Logout</title>
<link rel='stylesheet' href='../HomePage.css'>
<style> 
h1{
	width: 45%; 
	margin-left: auto; 
	margin-right: auto; 
}
#returnlink{
	width: 45%; 
	margin-left: 2em;
}
</style> 
</head> 
<body> 
<?php 
	require('header.php'); 
	if(!isset($_SESSION['loginstatus']) && !isset($_SESSION['username']) && !isset($_SESSION['privilege'])){
	echo "<h1>Logout was successful!</h1>"; 
	echo "<br><br><br>"; 
	echo "<a id='returnlink' href='../Products.php'>Return to products</a>";	
	}
	require('footer.php'); 
?> 
</body> 
</html> 