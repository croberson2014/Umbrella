<?php 
	
	/*
	Name: UserLogin.php
	Path: Root/project3/login.php
	Version: 1
	Function: This page serves as the login page for the user. It contains all messages that pertain to the credentials including success, server failure, and incorrect credentials. Additionally, 
	the admin credentials are located on this page.
	*/

@SESSION_START(); 
//check to make sure the fields are not left blank, validate them 
if(isset($_POST['submit'])){
	require('automate/login.php'); 
}
@session_start(); 
//echo "<p>".$_SESSION['username']."</p>"; 
//echo "<p>".$_SESSION['loginstatus']."</p>"; 
//echo "<p>".$_SESSION['privilege']"</p>"; 

?>
<html> 
<!--
	Name: UserLogin.php
	Path: Root/project3/UserLogin.php
	Version: 1
	Function : This page will verify user credentials. If it doesn't receive the correct 
	credentials, the user will be redirected back to this page and an error message will be 
	displayed. 
-->
<head> 
<title>Login</title>
<link rel='stylesheet' href='HomePage.css'>
<style> 
	#error{
		color: red; 
		left-margin: 3em; 	
		font-weight: bold; 
		text-align: center; 
		font-size: 1.25em;
	}
	#login_button{ 
		margin-left: auto; 
		margin-right: auto;
		color: white; 
		background: black; 
		border: 2px solid blue; 
		padding: 1em;
	}
	#buttongroup{
	margin-left: auto; 
	margin-right: auto; 
	width: 20%; 
	}
	label{
		margin-left: 1em;
	}
	input{
		margin-top: 1em;
	}
	h1{
		width: 30%; 
		margin-left: auto; 
		margin-right: auto; 
	}
</style>
</head> 
<body> 
<?php 
include("automate/header.php"); 
?>

<?php 
	@SESSION_START();  
	//isset($_SESSION['privilege']) ? $sess = $_SESSION['privilege'] : $sess = "NotSet"; 
	if(@$_SESSION['loginstatus'] == "IN"){
		print "<h1>Login was successful!</h1>
			<h2>Welcome ".$_SESSION['username']."!</h2>
			<br><br><br>"; 
		($_SESSION['privilege'] == "COMM") ? print "<a href='Products.php'>Go to products</a>" : print "<a href='automate/allusers.php'>View All Users</a>";
	}
?>

<form id='loginform' name='loginform' action='<?php $_SERVER['PHP_SELF'] ?>' method='post'>
<?php 
@SESSION_START(); 
if(@$_SESSION['loginstatus'] !== "IN"){
		print "<h1>Login to continue</h1>
		
		<div id='buttongroup'> 
			<br><br>
			<input type='text' id='username' name='username'><label>Username</label>
			<br>
			<input type='password' id='password' name='password'><label>Password</label> 
			<br><br><br>
			<input type='submit' value='Login' id='login_button' name='submit'>
			<p>Not a member? <a href='UserRegistration.php'>Register here</a></p>
		</div>"; 
		
		}
		
?>
	</form>
	
<?php
	@SESSION_START();  
	if(@$_SESSION['loginstatus'] == "PROBLEM"){
				echo "<br><br><p id='error'>Your user name or password is incorrect! Try Again!</p>";
	}
	if(@$_SESSION['loginstatus'] == "SERVER_ERROR"){
				echo "<p id='error'>The site will be unavailable due to maintenance. Please try back again shortly. </p>";
	}
?>
<?php 
include("automate/footer.php"); 
?>
</body>
</html>