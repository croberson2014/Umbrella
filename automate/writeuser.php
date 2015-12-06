<?php 
/*
	Name: writeuser.php
	Path: Root/project2/automate/write.php
	Version: 1
	Function : This script writes users to the psychic.inc file once registration
	is complete. 
*/
@SESSION_START(); 

if(strpos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php");  	
}
else{
	//check if the directory exists, if not, create it 
	/*$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT']; */
	$fp = ""; 
	$output = ""; 
	/*if(file_exists("$DOCUMENT_ROOT/project3/data/psychics.inc")){
		$fp = fopen("$DOCUMENT_ROOT/project3/data/psychics.inc", 'a');
	}
	else{
		$fp = fopen("$DOCUMENT_ROOT/project3/data/psychics.inc", 'w');
	}*/
	if(file_exists("../data/psychics.inc")){
		$fp = fopen("../data/psychics.inc", 'a');
	}
	else{
		$fp = fopen("../data/psychics.inc", 'w');
	}
	//check if the file exists, if not, create it 
	flock($fp, LOCK_EX); 
	
	//USER LEVEL FIELD
	$User_Level = "commercial";
	$output .= "\n".$User_Level."\t"; 

	//USER NAME FIELD
	//set max, purge tags
	isset($_POST['email1']) ? $User_Name = $_POST['email1'] : ($User_Name="");
	$output .= $User_Name."\t"; 
	
	//PASSWORD FIELD
	//set max, purge tags
	isset($_POST['password1']) ? $Password = $_POST['password1'] : ($Password="");
	isset($_POST['password2']) ? $Passcheck = $_POST['password2'] : ($Passcheck="");
	$output .= $Password."\t"; 
	
	//NAME FIELD
	//set max, purge tags 
	isset($_POST['firstname']) ? $First_Name=$_POST['firstname'] : ($First_Name=""); 
	$output .= $First_Name."\t"; 
	isset($_POST['lastname']) ? $Last_Name=$_POST['lastname'] : ($Last_Name=""); 
	$output .= $Last_Name."\t"; 
	isset($_POST['ailment']) ? $Comment=$_POST['ailment'] : ($Comment=""); 
	$output .= "\"".$Comment."\"\t"; 
	//Contains a substring of the placeholder text *add* later
	
	//DEMOGRAPHIC INFORMATION 
	//at least one box (should be automatic), the date 
	$Ethnicity = $_POST['ethnicity']; 
	$output .= $Ethnicity."\t"; 
	$Gender = $_POST['genderselect']; 
	$output .= $Gender."\t"; 
	isset($_POST['dob']) ? $DOB = $_POST['dob'] : $DOB = "1/1/1970"; 
	$output .= $DOB."\t"; 

	//CREDIT CARD INFORMATION 
	//set max, purge tags 
	isset($_POST['cardfirstname']) ? $Card_First_Name = $_POST['cardfirstname'] : $Card_First_Name = "";
	$output .= $Card_First_Name."\t"; 
	isset($_POST['cardmiddlename']) ? $Card_Middle_Name = $_POST['cardmiddlename'] : $Card_Middle_Name = "";
	$output .= $Card_Middle_Name."\t"; 
	isset($_POST['cardlastname']) ? $Card_Last_Name = $_POST['cardlastname'] : $Card_Last_Name = "";
	$output .= $Card_Last_Name."\t"; 
	//$Card_First_Name_Form = true; $Card_Middle_Name_Form = true; $Card_Last_Name_Form = true;
	
	//is a digit, max length set, purge tags
	isset($_POST['four1']) ? $Card_Number[0] = $_POST['four1'] : $Card_Number[0] = "";
	$output .= $Card_Number[0]."\t";
	isset($_POST['four2']) ? $Card_Number[1] = $_POST['four2'] : $Card_Number[1] = ""; 
	$output .= $Card_Number[1]."\t";
	isset($_POST['four3']) ? $Card_Number[2] = $_POST['four3'] : $Card_Number[2] = ""; 
	$output .= $Card_Number[2]."\t";
	isset($_POST['four4']) ? $Card_Number[3] = $_POST['four4'] : $Card_Number[3] = ""; 
	$output .= $Card_Number[3]."\t";
	//required? no
	
	isset($_POST['cardtype']) ? $Card_Type = $_POST['cardtype'] : $Card_Type = ""; 
	$output .= $Card_Type."\t"; 
	isset($_POST['expiration']) ? $Expiration = $_POST['expiration'] : $Expiration = ""; 
	$output .= $Expiration."\t"; 
	//required ? no
	
	isset($_POST['street']) ? $Card_Street = $_POST['street'] : $Card_Street = "";
	$output .= $Card_Street."\t"; 
	isset($_POST['city']) ? $Card_City = $_POST['city'] : $Card_City = ""; 
	$output .= $Card_City."\t"; 
	isset($_POST['state']) ? $Card_State = $_POST['state'] : $Card_State = ""; 
	$output .= $Card_State."\t"; 
	isset($_POST['zip']) ? $Card_Zip = $_POST['zip'] : $Card_Zip = ""; 
	$output .= $Card_Zip."\t"; 
	
	//append to the end of the file 
	fwrite($fp, $output); 
	flock($fp, LOCK_UN); 
	fclose($fp); 
	exit();
	}
?> 
