<?php
@SESSION_START(); 
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: UserLogin.php");  } 
?>
<html>
<!--
	Name: AdministratorHomePage.php
	Path: Root/project3/AdministratorHomePage.php
	Version: 1
	This page includes links to administrative tasks, such as viewing all users and editing the available products. 
--> 
<head> 
<title>Administrator Home</title>
<link rel='stylesheet' href='HomePage.css'>
</head> 
<body> 
<?php include("automate/header.php"); ?>

<?php include("automate/footer.php"); ?>
</body>
</html>