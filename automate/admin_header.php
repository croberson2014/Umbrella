<?php
/*
Name: admin_header.php
	Path: Root/project2/automate/admin_header.php
	Version: 1
	Contains the header for the administrator homepage. This page contains links to administrative tasks such as viewing the list of users and editing products (or adding them). 
*/
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
@SESSION_START();  
if(strpos(getcwd(), "automate") !== false){
print "<img src='../pictures/umbrellalogo.jpg' id='logo'><br>
		<div id='nav_bar'>
		<ul>
		<li><a href='allusers.php?q=SHOW'>View Users</a></li>
		<li><a href='allusers.php?q=EDIT'>Edit Users</a></li>
		<li><a href='../EditProducts.php'>Edit Products</a></li>
		<li><a href='../EditCategories.php'>Edit Categories</a></li>
		<li><a href='../SelectFile.php'>Upload Image</a></li>
		</ul>
		</div>
		<hr>
		<fieldset id='outerfield' class='field'>
		<div id='login'>
			<ul id='comm_list'>
				<li><p><b>Administrator: ".$_SESSION['username']."</b></p></li>
				<li><a href='logout.php'>Logout</a></li>
			</ul>
		</div>
		<fieldset id='innerfield' class='field'>";
		
}
else{
print	"<img src='pictures/umbrellalogo.jpg' id='logo'><br>
		<div id='nav_bar'>
		<ul>
		<li><a href='automate/allusers.php?q=SHOW'>View Users</a></li>
		<li><a href='automate/allusers.php?q=EDIT'>Edit Users</a></li>
		<li><a href='EditProducts.php'>Edit Products</a></li>
		<li><a href='EditCategories.php'>Edit Categories</a></li>
		<li><a href='SelectFile.php'>Upload Image</a></li>
		</ul>
		</div>
		<hr>
		<fieldset id='outerfield' class='field'>
		<div id='login'>
			<ul id='comm_list'>
				<li><p><b>Administrator: ".$_SESSION['username']."</b></p></li>
				<li><a href='automate/logout.php'>Logout</a></li>
			</ul>
		</div>
		<fieldset id='innerfield' class='field'>";
		
}
?>