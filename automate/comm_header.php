<?php
/*
Name: comm_header.php
	Path: Root/project2/automate/comm_header.php
	Version: 1
	Contains a header that identifies the user on each page. Eventually it will contain a link for the user to access and edit their personal information. 
*/
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
@SESSION_START(); 
if(strpos(getcwd(), "automate") !== false){
print "<img src='./pictures/umbrellalogo.jpg' id='logo'><br>
		<div id='nav_bar'>
		<ul>
		<li><a href='./HomePage.php'>About</a></li>
		<li><a href='./Products.php'>Products</a></li>
		</ul>
		</div>
		<hr>
		<fieldset id='outerfield' class='field'>
		<div id='login'>
			<ul id='comm_list'>
				<li><p><b>Welcome ".$_SESSION['username']."</b></p></li>
				<li><a href='logout.php'>Logout</a></li>
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
			<ul id='comm_list'>
				<li><p><b>Welcome ".$_SESSION['username']."</b></p></li>
				<li><a href='automate/logout.php'>Logout</a></li>
			</ul>
		</div>
		<fieldset id='innerfield' class='field'>";
}
?>