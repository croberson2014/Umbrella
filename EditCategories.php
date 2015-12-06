<?php 
@session_start(); 
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: UserLogin.php");  } ?>
<html> 
<head> 
<link rel='stylesheet' href='HomePage.css'>
<script src='plugins/jquery-1.11.3.js'></script>
<script> 
$(document).ready(function() {
//alert(); 
$('#comm_list').after("<ul style='float: left; margin-left: 5em;' ><li><button id='addCat' style='background-color: white; color: black; font-weight: bold; font-size: 2em; border: 4px solid blue; ' >Add Category</button></li></ul>"); 
$('#addCat').click(function (){
//alert(); 
$.post('automate/product_functions.php', 'q=addCategory', processResponse);
}); 

$('.deleteCategory').click(function(){
	alert($(this).val()); 
	$.post('automate/product_functions.php' , 'q=removeCategory&r='+$(this).val(), processResponse); 
}); 

$('.updateCategory').change(function(){
	alert($(this).val()); 
	alert($(this).attr('id')); 
	$.post('automate/product_functions.php' , 'q=updateCategory&r='+$(this).attr('id')+'&s='+$(this).val(), processResponse);
}); 
 
}); 
function processResponse(data){
	var process = jQuery.parseJSON(data);
	if(process.selector == '#removeCategory'){
		//$.post('EditCategories.php', 'q=end', alert());
		window.location.replace('EditCategories.php'); 
	}
	if(process.selector == '#addCategory'){
		window.location.replace('EditCategories.php');  
	}
	if(process.selector == '#updateCategory'){
	
	}
}
</script> 
</head> 
<body> 
<?php include('automate/header.php'); 
include('automate/product_functions.php'); ?> 
<?php
$db = connect(0, 0, 0); 
$result = $db->query('select category_id, name from CATEGORY'); 
$num_results = $result->num_rows; 
$c = ""; $n = ""; 
echo "<table>"; 
for($i = 0; $i < $num_results; $i++){
	$row = $result->fetch_assoc(); 
	$c[$i] = $row['category_id']; 
	$n[$i] = $row['name']; 
	echo "</tr>"; 
	//style='border : none; margin-left: 1em; margin-right: 10em; font-size: 2em; font-weight: bold;' 
	echo "<td><h2>No. ".$c[$i]."</h2></td><td><input class='updateCategory' id=".$c[$i]." style = 'font-size: 3em; margin-right: 5em;' value='".$row['name']."' ></td>"; 
	echo "<td><button class='deleteCategory' style='background-color: black; color : white; border: 5px solid red;' value=".$c[$i]."><h2>Delete</h2></button></td></tr>"; 
	}
echo "</table>"; 

?>
<?php include('automate/footer.php'); ?>
</body> 
</html> 

