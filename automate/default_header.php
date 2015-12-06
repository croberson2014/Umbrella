<?php 
/*
Name: default_header.php
	Path: Root/project2/automate/default_header.php
	Version: 1
	The header that appears when no user is logged in. Displays login and register links, as well as the product and informational pages. 
*/
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
	@SESSION_START(); 
	if(strpos(getcwd(), "automate") !== false){

		print "<img src='../pictures/umbrellalogo.jpg' id='logo'><br>
		<div id='nav_bar'>
		<ul>
		<li><a href='../HomePage.php'>About</a></li>
		<li><a href='../Products.php'>Products</a></li>
		</ul>
		</div>
		<hr>
		<fieldset id='outerfield' class='field'>
		<div id='login'>
		<ul>
		<li><a href='../UserLogin.php'>Login</a></li>
		<li><a href='../UserRegistration.php'>Register</a></li>
		</ul>
		</div>
		<fieldset id='innerfield' class='field'>";	
		}
	else{
	print "<img src='pictures/umbrellalogo.jpg' id='logo'><br>
		<div id='nav_bar'>
		<ul>
		<li><a href='HomePage.php'>About</a></li>
		<li><a href='Products.php'>Products</a></li>
		</ul>
		</div>
		<hr>
		<fieldset id='outerfield' class='field'>
		<div id='login'>
		<ul>
		<li><a href='UserLogin.php'>Login</a></li>
		<li><a href='UserRegistration.php'>Register</a></li>
		</ul>
		</div>
		<fieldset id='innerfield' class='field'>";
		}
?> 