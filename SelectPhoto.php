<?php 
@session_start(); 
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: UserLogin.php");  } ?>
<html> 
<head> 
<link rel='stylesheet' href='HomePage.css'>
<script src='plugins/jquery-1.11.3.js'></script>
<script> 

$(document).ready(function(){
$('.photo').click(function(){
	//alert(); 
	//alert($(this > 'image').attr('src')); 
}); 
}); 
var a = ""; 
function sendPhoto(source, id, cat){
	/*alert(source); 
	alert(id);
	alert(cat); */
	if(id == 'EXIT'){
	//alert('Failed'); 
	}else{
	//$.post('automate/product_functions.php', 'q=uploadPhoto&r='+id+'&s='+source, alert());  
	$.post('automate/product_functions.php', 'q=uploadPhoto&r='+id+'&s='+source, window.location.replace('EditProducts.php?q='+id+'&r='+cat));  
	}
	//window.location.replace('EditProducts.php'); 
}
</script> 
</head> 
<body>
<?php 
	include('automate/header.php'); 
	if(isset($_REQUEST['q']) && isset($_REQUEST['r'])){
	$q = htmlspecialchars(strip_tags($_REQUEST['q']));
	$r = htmlspecialchars(strip_tags($_REQUEST['r'])); 
	}
	else{
	$q = 'EXIT'; 
	}
	//echo "<p>".$q."</p>"; 
	//@session_start(); 
	//$q = $_SESSION['currentproduct']; 
	$dir = dir("uploads/"); 
	while(false !== ($file = $dir->read()))
	{
		if($file != "." && $file != ".."){
			echo "<image onclick=\"sendPhoto($(this).attr('src'), '".$q."', '".$r."')\" style='width: 200px; height: 200px; margin: 15px; ' src='uploads/$file'>"; 
		}
		//<button class='photo' style='margin: 1em; padding: 1em; background-color: black; border: 2px solid blue;'></button>
	}
	echo "</ul>"; 
	$dir->close();
	echo "<br><br><a style='font-size: 3em; margin-left: 5em; display: table-row; ' href='EditProducts.php' >Return to Edit Products</a>"; 
	include('automate/footer.php'); 
?> 
</body> 
</html>