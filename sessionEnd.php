<?php 
	@session_start(); 
	$_SESSION = array(); 
	@session_destroy(); 
?> 
<html> 
<body> 
<h1>Session should be done</h1> 
</body> 
</html> 