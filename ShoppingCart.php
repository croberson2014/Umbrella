<?php 
	include('automate/sales_functions.php'); 
?> 
<html> 
<head> 
<link rel='stylesheet' href='HomePage.css'>
<style>
td{
	margin: 1em; 
	padding: 1em;
} 
#cardcode{
	float: right; 
}
#submitbutton{
	margin-left: 2em; 
	margin-right: auto; 
	width: 90%; 
	background-color: black; 
	color: white; 
	border: 2px solid blue; 
	font-size: 16px; 
	padding: 1em; 
}
.formerror{
	color: red; 
	font-weight: bold; 
}
.thumbs{
	width=50px; 
	height=50px; 
}
</style> 
</head> 
<body> 
<?php 
include('automate/header.php'); 
@$q = $_GET['q']; 
echo "<p>Q : ".$q." </p>";

switch($q){
	case 'authenticate' : authenticatePaymentMethodPOST();  break; 
	case 'cart' : displayCart(); break; 
	case 'authenticateCart' : authenticateCartPOST(); break; 
	case 'payment' : displayPaymentMethod(); break; 
	default : displayPaymentMethod(); break; 
}


include('automate/footer.php'); 

?> 
</body> 
</html> 