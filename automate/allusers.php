<?php
@SESSION_START(); 
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: ../UserLogin.php");  } 
?>

<html> 
<head>
<!--
	Name: allusers.php
	Path: Root/project2/automate/allusers.php
	Version: 1
	Function : This script displays all of the users that are located in the 
	psychics.inc file
-->
<link rel='stylesheet' href='../HomePage.css'> 
<script src='../plugins/jquery-1.11.3.js' type='text/javascript'></script> 
</head>
<body>
<?php
require('header.php'); 
?>
<!--
<img src='../pictures/umbrellalogo.jpg' id='logo'><br>
		<div id='nav_bar'>
		<ul>
		<li><a href='../HomePage.php'>About</a></li>
		<li><a href='../Products.php'>Products</a></li>
		</ul>
		</div>
		<hr>
	<fieldset id='outerfield' class='field'>
	<fieldset id='innerfield' class='field'>
	-->
<style>
	
	table{
		margin-left: 1em;
	}
	tr:hover{
		background-color: red; 
	}
	.alt:hover{
		background-color: blue; 
	}
	tr:first{
		font-weight: bold; 
	}
	td{
		border: 2px solid black;
		padding: 1em;
	}
	#innerfield{
		//margin-top: 3em;
	}
	#outerfield{
		margin: 0em; 
	}
</style>
<script>
var column; var value; 
$(document).ready(function (){
$('.eu').change(function (){
	
});
//.change($.post("user_functions.php" , "q=updateUser&r=" ))
}); 
function myFunction(){
	//alert(); 
}
function updateUser(id, column, value){
	//alert(id); alert(column); alert(value);
		$.post("user_functions.php", "q=updateUser&r="+id+"&s="+column+"&t="+value, respond); 
		 
}
function deleteUser(id){ 
	$.post("user_functions.php", "q=deleteUser&r="+id, respond); 
	
}
function respond(){

}
</script> 

<?php
require('user_functions.php');
//SESSION ACTIVE
@$q = $_REQUEST['q'];
if(!$redir){
	
	if($q == 'SHOW'){
	
	/*$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT']; 
	$fp = ""; */
	/*if(file_exists("$DOCUMENT_ROOT/project3/data/psychics.inc")){ 
		$fp = fopen("$DOCUMENT_ROOT/project3/data/psychics.inc", 'r');
		if(file_exists("../data/psychics.inc")){ 
		$fp = fopen("../data/psychics.inc", 'r');*/
	//echo "<tr><td>User Privilege</td><td>User Name</td><td>Password</td><td>First Name</td>
	//<td>Last Name</td><td>Illness</td><td>Ethnicity</td><td>Gender</td><td>Date of Birth</td></tr>"; 
	/*while(!feof($fp)){ 
		echo "<tr>"; 
		$lines = fgetcsv($fp, 999, "\t"); 
		$y = new User;
		$y->setUserLevel($lines[0]); 
		echo "<td>".$y->getUserLevel()."</td>";
		$y->setUserName($lines[1]); 
		echo "<td>".$y->getUserName()."</td>"; 
		$y->setPass($lines[2]); 
		echo "<td>".$y->getPass()."</td>";
		$y->setFirstName($lines[3]); 
		echo "<td>".$y->getFirstName()."</td>"; 
		$y->setLastName($lines[4]); 
		echo "<td>".$y->getLastName()."</td>"; 
		$y->setAilment($lines[5]); 
		echo "<td class='wrap'>".$y->getAilment()."</td>"; 
		$y->setEthnicity($lines[6]); 
		echo "<td>".$y->getEthnicity()."</td>"; 
		$y->setGender($lines[7]); 
		echo "<td>".$y->getGender()."</td>";
		$y->setDOB($lines[8]); 
		echo "<td>".$y->getDOB()."</td>"; 
		echo "</tr>"; 
	}*/
	displayUsers('SHOW'); 
	}
	elseif($q == 'EDIT'){
		displayUsers('EDIT'); 
	}
	else{
		echo "<p>The site doesn't have any users yet...</p>"; 
	}
	//check if the file exists, if not, create it 
}
else{
}


?>
<?php 
require('footer.php'); 
?>
</fieldset>
</fieldset>
</body> 
</html>