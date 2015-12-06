<?php 
/*
	Name: validate.php
	Path: Root/project2/automate/validate.php
	Version: 1
	Function : This script performs server side validation on all form inputs, 
	and displays an error message if the input is not valid. 
	***DEPRECATED, most validation functions have been switched to the 'automate/global_functions.php'
*/

if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
	

/*if(!$_SESSION['registration'] == true){
	header("Location: ../HomePage.php");
}*/
	$valid = true; 
	
	//USER NAME FIELD
	//set max *, purge tags*
	isset($_POST['email1']) ? $User_Name = strip_tags(htmlspecialchars($_POST['email1'])) : ($User_Name="");
	$User_Name_Form = true; 
	if($User_Name == ""){$valid = false; $User_Name_Form = false;}
	isset($_POST['email2']) ? $User_Check = strip_tags(htmlspecialchars($_POST['email2'])) : ($User_Check="");
	$User_Check_Form = true; 
	if($User_Check == ""){$valid = false; $User_Check_Form = false;}
	$User_Match = true; 
	if(!($User_Name == $User_Check)){$valid = false; $User_Match=false;}
	
	//PASSWORD FIELD
	//set max*, purge tags*
	isset($_POST['password1']) ? strip_tags(htmlspecialchars($Password = $_POST['password1'])) : ($Password="");
	isset($_POST['password2']) ? strip_tags(htmlspecialchars($Passcheck = $_POST['password2'])) : ($Passcheck="");
	$Password_Form = true;
	if($Password == ""){$valid = false; $Password_Form = false;}
	if($Passcheck == ""){$valid = false; $Password_Form = false;} 
	if(!($Password == $Passcheck)){$valid = false; } 
	
	//NAME FIELD
	//set max, purge tags 
	isset($_POST['firstname']) ? $First_Name=strip_tags(htmlspecialchars($_POST['firstname'])) : ($First_Name=""); 
	$First_Name_Form = true; 
	if($First_Name == ""){$valid = false; $First_Name_Form=false;}
	isset($_POST['lastname']) ? $Last_Name=strip_tags(htmlspecialchars($_POST['lastname'])) : ($Last_Name=""); 
	$First_Name_Form = true; 
	if($Last_Name == ""){$valid = false; $Last_Name_Form=false;} 
	isset($_POST['ailment']) ? $Comment=strip_tags(htmlspecialchars($_POST['ailment'])) : ($Comment=""); 
	$Comment_Form = true; 
	//Contains a substring of the placeholder text *add* later
	if($Comment == "" || "List any known illness or describe the illness(es)."){$Comment_Form=false;} 
	
	//DEMOGRAPHIC INFORMATION 
	//at least one box (should be automatic), the date 
	$Ethnicity = strip_tags(htmlspecialchars($_POST['ethnicity'])); 
	$Gender = strip_tags(htmlspecialchars($_POST['genderselect'])); 
	isset($_POST['dob']) ? $DOB = strip_tags(htmlspecialchars($_POST['dob'])) : ($DOB = ""); 
	$DOB_Form = true; 
	if($DOB == ""){$valid = false; $DOB_Form = false; } //if(!preg_match("[0-1][1-12]\/[0-1][1-31]\/[1900-2015]", $DOB)){$valid = false; $DOB_Form = false;}
	
	
	//CREDIT CARD INFORMATION 
	//set max, purge tags 
	isset($_POST['cardfirstname']) ? $Card_First_Name = strip_tags(htmlspecialchars($_POST['cardfirstname'])) : $Card_First_Name = ""; 
	isset($_POST['cardmiddlename']) ? $Card_Middle_Name = strip_tags(htmlspecialchars($_POST['cardmiddlename'])) : $Card_Middle_Name = "";
	isset($_POST['cardlastname']) ? $Card_Last_Name = strip_tags(htmlspecialchars($_POST['cardlastname'])) : $Card_Last_Name = "";
	//$Card_First_Name_Form = true; $Card_Middle_Name_Form = true; $Card_Last_Name_Form = true;
	
	//is a digit, max length set, purge tags
	isset($_POST['four1']) ? $Card_Number[0] = strip_tags(htmlspecialchars($_POST['four1'])) : $Card_Number[0] = ""; 
	isset($_POST['four2']) ? $Card_Number[1] = strip_tags(htmlspecialchars($_POST['four2'])) : $Card_Number[1] = ""; 
	isset($_POST['four3']) ? $Card_Number[2] = strip_tags(htmlspecialchars($_POST['four3'])) : $Card_Number[2] = ""; 
	isset($_POST['four4']) ? $Card_Number[3] = strip_tags(htmlspecialchars($_POST['four4'])) : $Card_Number[3] = ""; 
	//required? no
	
	isset($_POST['cardtype']) ? $Card_Type = strip_tags(htmlspecialchars($_POST['cardtype'])) : $Card_Type = ""; 
	isset($_POST['expiration']) ? $Expiration = strip_tags(htmlspecialchars($_POST['expiration'])) : $Expiration = ""; 
	//required ? no
	
	isset($_POST['street']) ? $Card_Street = strip_tags(htmlspecialchars($_POST['street'])) : $Card_Street = "";
	isset($_POST['city']) ? $Card_City = strip_tags(htmlspecialchars($_POST['city'])) : $Card_City = ""; 
	isset($_POST['state']) ? $Card_State = strip_tags(htmlspecialchars($_POST['state'])) : $Card_State = ""; 
	isset($_POST['zip']) ? $Card_Zip = strip_tags(htmlspecialchars($_POST['zip'])) : $Card_Zip = ""; 
	
	
	if($valid){
		echo "<h1>Congratulations on completing your registration $First_Name!</h1>"; 
		echo "<p>User Name: ".$User_Name."</p>"; 
		echo "<p>Password: ".$Password."</p>"; 
		echo "<p>First Name : ".$First_Name."</p>"; 
			echo "<input type='hidden' name='firstname' value='".$First_Name."'>";
		echo "<p>Last Name : ".$Last_Name."</p>"; 
		echo "<p>Ailment : ".$Comment."</p>"; 
		echo "<p>Ethnicity : ".$Ethnicity."</p>"; 
		echo "<p>Gender : ".$Gender."</p>"; 
		echo "<p>Date of Birth : ".$DOB."</p>"; 
		echo "<p>Name of Card Holder : ".$Card_First_Name." ".$Card_Middle_Name." ".$Card_Last_Name."</p>"; 
		echo "<p>Card Number : ".$Card_Number[0]."-".$Card_Number[1]."-".$Card_Number[2]."-".$Card_Number[3]."</p>"; 
		echo "<p>Card Type : ".$Card_Type."</p>"; 
		echo "<p>Expiration Date : ".$Expiration."</p>"; 
		echo "<p>Address <br>&nbsp&nbsp&nbsp Street : ".$Card_Street."<br>&nbsp&nbsp&nbsp City : ".$Card_City."<br>&nbsp&nbsp&nbsp State : ".$Card_State."<br>&nbsp&nbsp&nbsp Zip Code : ".$Card_Zip."</p>";
		echo "<a href='../HomePage.php'>Return to Home Page</a>"; 
		$_SESSION['username'] = $User_Name; 
		$_SESSION['privilege'] = "COMM"; 
		$_SESSION['loginstatus'] = "IN"; 
		//write user 
		require("writeuser.php"); 
	}
	else{
		echo "<p>The form is invalid</p>"; 
		if(!$User_Name_Form){
			echo "<p>User Name was entered incorrectly</p>";
		}
		if(!$User_Check_Form){
			echo "<p>User re-entered User Name was entered incorrectly</p>";
		}
		if(!$User_Match){
			echo "<p>The user names do not match. </p>"; 
		}
		if(!$Password_Form){
			echo "<p>The password was entered incorrectly</p>";
		}
		if(!$DOB_Form){
			echo "<p>Please enter a date of birth!</p>"; 
		}
		exit();
	}
	
?> 