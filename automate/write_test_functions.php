<?php 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
include('global_functions.php'); 
function writeUser($user){
	//TABLE -> CUSTOMER 
	
	// write default ADDRESS which should be 0
	
	// 
}
function writeDemographic($demographic){

}
function validateUser($user){
	
}
function postUser(){

	isset($_POST['email1']) ? $user->login = strip_tags(htmlspecialchars($_POST['email1'])) : ($user->login="");
	if($User_Name == ""){$valid = false; $User_Name_Form = false;}
	isset($_POST['email2']) ? $User_Check = strip_tags(htmlspecialchars($_POST['email2'])) : ($User_Check="");
	$User_Check_Form = true; 
	if($User_Check == ""){$valid = false; $User_Check_Form = false;}
	$User_Match = true; 
	if(!($User_Name == $User_Check)){$valid = false; $User_Match=false;}
	
	return $user; 
}
/*function updateUser($option, $id){
$db = new mysqli('localhost', getDBUserName(1), getDBPassword(1), getDBName(1)); 
	if(mysqli_connecterrno()){
		return false; 
	}
	
	

}*/
/*
function writeUserDemographic(){

}

function writePaymentMethod(){

}

function writeUserCredentials(){

}

*/
?> 