<?php
/*
Name: header.php
	Path: Root/project2/automate/header.php
	Version: 3
	Function : This script determines the links that will be displayed, occassionally 
	sets style elements of a page, and has circuits designed to get the correct 
	path to other files based on teh current directory. 
	
	Version 3 Note: Additional subheader files were made to distribute the workload to allow fast alterations if necessary. 
	This page acts as a switchboard to direct execution to the correct script at runtime. 
*/
//if(getcwd() == //"C:/wamp/www/project2/automate")

//The issue here is that the paths to the subheader files themselves needs to be altered or forked otherwise they will not be loaded properly. 

/*if($_SERVER['PHP_SELF'] !== "/project3/automate/logout.php"){
	session_start(); 
}*/
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
@SESSION_START(); 

/*isset($_SESSION['loginstatus']) ? $_SESSION['loginstatus'] = $_SESSION['loginstatus'] : $_SESSION['loginstatus'] = "Unknown"; */
if(strpos(getcwd(), "automate") !== false){

	if(@$_SESSION['loginstatus'] == "IN" && @$_SESSION['privilege'] == "ADMIN"){require('admin_header.php');}
	elseif(@$_SESSION['loginstatus'] == "IN" && @$_SESSION['privilege'] == "COMM"){require('comm_header.php');}
	else{require('default_header.php');}

}
else{
	if(@$_SESSION['loginstatus'] == "IN" && @$_SESSION['privilege'] == "ADMIN"){require('automate/admin_header.php'); }
	elseif(@$_SESSION['loginstatus'] == "IN" && @$_SESSION['privilege'] == "COMM"){require('automate/comm_header.php'); }
	else{require('automate/default_header.php'); }
}
?> 