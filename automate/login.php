<!--

	Name: login.php
	Path: Root/project3/automate/login.php
	Version: 2
	Function : This page is used to encapsulate the user login from the administrative login, thus making the code easier to read. This script will check through the list 
	of user names and passwords to see if any of them match the credentials entered by the user in UserLogin.php.
	Version updates: Now utilizes a mySQL database username and password. 
-->
<?php  
 
	if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
	} 
	include('global_functions.php');
	@SESSION_START(); 
	/*$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT']; 
	echo "<p>$DOCUMENT_ROOT</p>"; 
	$fp = ""; */
	$username = $_POST['username']; $password = $_POST['password']; 
	$username = strip_tags(htmlspecialchars($username));
	$password = sha1(strip_tags(htmlspecialchars($password))); 
	$db = connect(0, 0, 0);
	$result = $db->query("select login, privilege from USER where login='".$username."' and password='".$password."'"); 
	$num_results = $result->num_rows; 
	 
	echo "<p>The number of results : ".$num_results."</p>"; 
	if($num_results >= 1){
		$row = $result->fetch_assoc();
		$_SESSION['username'] = $username; 
		echo "<p>Session Username : ".$_SESSION['username']."</p>"; 
			$_SESSION['loginstatus'] = "IN"; 
			echo "<p>Login status : ".$_SESSION['loginstatus']."</p>";
			echo "<p>Privilege : ".$row['privilege']."</p>"; 
			$_SESSION['privilege'] = $row['privilege']; 
			echo "<p>Session Privilege : ".$_SESSION['privilege']."</p>"; 
		
			
			$username = ""; $password = ""; 
			unset($_POST); 
			$_POST = array(); 
	}
	
	/*if(file_exists("$DOCUMENT_ROOT/project3/data/psychics.inc")){
	$fp = fopen("$DOCUMENT_ROOT/project3/data/psychics.inc", 'r'); */

	/*if(file_exists("data/psychics.inc")){
	$fp = fopen("data/psychics.inc", 'r');
	flock($fp, LOCK_EX); 
	while(!feof($fp)){ 
		$lines = fgetcsv($fp, 999, "\t");  */
//r4b1nA5tr3
	//}
	 
	/*flock($fp, LOCK_UN); 
	fclose($fp);*/
	
	if(@$_SESSION['loginstatus'] !== "IN"){
	$_SESSION['loginstatus'] = "PROBLEM"; 
	}
	/*else{//IF THE FILE DOES NOT EXIST 
	$_SESSION['loginstatus'] = "SERVER_ERROR"; 
		
	}*/
	/*header("Location: ./UserLogin.php"); */
?>