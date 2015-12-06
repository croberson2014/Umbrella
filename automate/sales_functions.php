<?php 
	if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
	/*function processPayment($cardnum){
		$x = rand(1, 101); 
		
		($x <= 95) ? return true : return false; 
	}*/
	
//	include('card.php'); 
	include('global_functions.php'); 	
	@session_start(); 
	$_SESSION['cart'][0] = 0; 
	$_SESSION['cart'][1] = 10; 
	$_SESSION['cart'][2] = 7; 
	
	for($z = 0; $z < count($_SESSION['cart']); $z++){ 
		echo "<p>".$_SESSION['cart'][$z]."</p>"; 
	}
		
	function displayOrders(){
	
		$p = @$_SESSION('privilege'); 
		
		if($p == "COMM"){
		
		}
		if($p == "ADMIN"){
		
		}
		
	}
	
	function displayPaymentMethod(){
		print "<form action='ShoppingCart.php?q=authenticate' method='POST'> 
		<div id='paymentform' class='section'>
		<h2 id='cardsection'>Credit Card Information</h2>
		<div>
		<span id='cardname'>
			<label id='cardnamesub' class='cardlabel'><b>Name of Cardholder</b></label><br><br>
			<label class='cardnamelabel'>First Name</label><input maxlength='20' name='cardfirstname'type='text' id='cardfirstname' value=''>
			<label class='cardnamelabel'>Middle Name</label><input maxlength='20' name='cardmiddlename' type='text' id='cardmiddlename' value=''>
			<label class='cardnamelabel'>Last Name</label><input maxlength='20' name='cardlastname' id='cardlastname' value=''>
		</span>
			<br><br><br>
		<span id='cardcode'>
			<label class='cardlabel'><b>Card Number</b></label></br><br>
		<span id='cardnumber'>
			<input type='text' maxlength='4' name='four1' id='four1' value='' placeholder='XXXX'>-
			<input type='text' maxlength='4' name='four2' id='four2' value='' placeholder='XXXX'>-
			<input type='text' maxlength='4' name='four3' id='four3' value='' placeholder='XXXX'>-
			<input type='text' maxlength='4'  name='four4' id='four4' value='' placeholder='XXXX'>
		</span><br><br><br>
		<label id='expirationlabel'>Expiration</label><input type='datetime' value='' name='expiration' id='expiration'>
		<label id='cardtypelabel'>Type</label>
			<select id='cardtype' name='cardtype'>
			<option name='cardtype' value='Visa'>Visa</option> 
			<option name='cardtype' value='Mastercard'>Mastercard</option> 
			<option name='cardtype' value='American Express'>American Express</option> 
			</select> 
		<br><br><br>
		</span>
		</div>
		<div id='address' class='location'>
		<label id='addresssub'><b>Address</b></label><br><br>
		<label class='addresslabel'>Street</label><input maxlength='20' type='text' id='street' name='street' value=''><br><br>
		<label class='addresslabel'>City</label><input maxlength='30' type='text' id='city' name='city' value=''><br><br>
		<label class='addresslabel'>State</label>
		<select id='state' name='state'>
		<option value='AL' name='state'>Alabama(AL)</option>
		<option value='AK'	name='state'>Alaska(AK)</option><option name='state' value='AZ'>Arizona(AZ)</option><option name='state' value='AR'>Arkansas(AR)</option><option name='state' value='CA'>California(CA)</option><option name='state' value='CO'>Colorado(CO)</option>
		<option name='state' value='CT'>Connecticut(CT)</option><option name='state' value='DE'>Delaware(DE)</option><option name='state' value='FL'>Florida(FL)</option><option name='state' value='GA'>Georgia(GA)</option><option name='state' value='HI'>Hawaii(HI)</option>
		<option name='state' value='ID'>Idaho(ID)</option><option name='state' value='IL'>Illinois(IL)</option><option name='state' value='IN'>Indiana(IN)</option><option name='state' value='IA'>Iowa(IA)</option><option name='state' value='KS'>Kansas(KS)</option>
		<option name='state' value='KY'>Kentucky(KY)</option><option name='state' value='LA'>Louisiana(LA)</option><option name='state' value='ME'>Maine(ME)</option><option name='state' value='MD'>Maryland(MD)</option><option name='state' value='MA'>Massachusetts(MA)</option>
		<option name='state' value='MI'>Michigan(MI)</option><option name='state' value='MN'>Minnesota(MN)</option><option name='state' value='MS'>Mississippi(MS)</option><option name='state' value='MO'>Missouri(MO)</option><option name='state' value='MT'>Montana(MT)</option>
		<option name='state' value='NE'>Nebraska(NE)</option><option name='state' value='NV'>Nevada(NV)</option><option name='state' value='NH'>New Hampshire(NH)</option><option name='state' value='NJ'>New Jersey(NJ)</option><option name='state' value='NM'>New Mexico(NM)</option>
		<option name='state' value='NY'>New York(NY)</option><option name='state' value='NC'>North Carolina(NC)</option><option name='state' value='ND'>North Dakota(ND)</option><option name='state' value='OH'>Ohio(OH)</option><option name='state' value='OK'>Oklahoma(OK)</option>
		<option name='state' value='OR'>Oregon(OR)</option><option name='state' value='PA'>Pennsylvania(PA)</option><option name='state' value='RI'>Rhode Island(RI)</option><option name='state' value='SC'>South Carolina(SC)</option><option name='state' value='SD'>South Dakota(SD)</option>
		<option name='state' value='TN'>Tennessee(TN)</option><option name='state' value='TX'>Texas(TX)</option><option name='state' value='UT'>Utah(UT)</option><option name='state' value='VT'>Vermont(VT)</option><option name='state' value='VA'>Virginia(VA)</option>
		<option name='state' value='WA'>Washington(WA)</option><option name='state' value='WV'>West Virginia(WV)</option><option name='state' value='WI'>Wisconsin(WI)</option><option name='state' value='WY'>Wyoming(WY)</option>
		</select>
		<br><br>
		<label class='addresslabel'>Zip Code</label><input maxlength='5' type='text' id='zip' name='zip' value=''><br><br>
		<label class='addresslabel'>Apt. </label><input maxlength='15' type='text' id='apt' name='apt' value=''>
		</div>
	</div>
	<br>
	<input type='submit' value='Submit' id='submitbutton'>
	</form>"; 
	}
	
	function authenticatePaymentMethodPOST(){
		//cardfirst, middle, lastname
		$error = array(); 
		isset($_POST['cardfirstname']) ? $name[0] = htmlspecialchars(strip_tags($_POST['cardfirstname'])) : $name[0] = "";  
		isset($_POST['cardmiddlename']) ? $name[1] = htmlspecialchars(strip_tags($_POST['cardmiddlename'])) : $name[1] = "";  
		isset($_POST['cardlastname']) ? $name[2] = htmlspecialchars(strip_tags($_POST['cardlastname'])) : $name[2] = ""; 
		for($i = 0; $i < count($name); $i++){
			if($name[$i] == ""){
				$error[] = "Name field cannot be left blank!"; 
			}
		}
		//four1, four2, four3, four4 
		isset($_POST['four1']) ? $cardnum[0] = htmlspecialchars(strip_tags($_POST['four1'])) : $cardnum[0] = ""; 
		isset($_POST['four2']) ? $cardnum[1] = htmlspecialchars(strip_tags($_POST['four2'])) : $cardnum[1] = ""; 
		isset($_POST['four3']) ? $cardnum[2] = htmlspecialchars(strip_tags($_POST['four3'])) : $cardnum[2] = "";
		isset($_POST['four4']) ? $cardnum[3] = htmlspecialchars(strip_tags($_POST['four4'])) : $cardnum[3] = ""; 
		
		for($j = 0; $j < count($cardnum); $j++){
			if($cardnum[$j] == ""){
				$error[] = "Please enter four digits in card number field : ". $j; 
			}
			if(!is_numeric($cardnum[$j])){
				$error[] = "Only integer values are accepted in card number field : ". $j; 
			}
		}
		
		//expiration, cardtype
		isset($_POST['expiration']) ? $exp = htmlspecialchars(strip_tags($_POST['expiration'])) : $exp = ""; 
		if($exp == ""){$error[] = "Expiration field must not be left empty!"; }
		isset($_POST['cardtype']) ? $type = htmlspecialchars(strip_tags($_POST['cardtype'])) : $type = ""; 
		if($type == ""){$error[] = "Card type field must not be left empty!"; }
		
		//street, city, state, zip, apt 
		isset($_POST['street']) ? $street = htmlspecialchars(strip_tags($_POST['street'])) : $street = "";
		if($street == ""){$error[] = "Street field must not be empty!"; }
		isset($_POST['city']) ? $city = htmlspecialchars(strip_tags($_POST['city'])) : $city = "";
		if($city == ""){$error[] = "City field must not be empty!"; }
		isset($_POST['zip']) ? $zip = htmlspecialchars(strip_tags($_POST['zip'])) : $zip = "";
		if($zip == ""){$error[] = "Zip field must not be empty!"; }
		if(!is_numeric($zip)){ $error[] = "Zip must be an integer!"; }
		isset($_POST['apt']) ? $apt = htmlspecialchars(strip_tags($_POST['apt'])) : $apt = ""; 
		if($apt == ""){ $error[] ="Apartment field must not be left blank!"; }
		
		if(count($error) > 0){
			displayPaymentMethod(); 
			for($d = 0; $d < count($error); $d++){
				echo "<label class='formerror'>".$error[$d]."</label><br>"; 
			}
		}
		else{
			displayOrderConfirmation(); 
		}
	}
	
	function displayOrderConfirmation(){
	
	echo "<form action='ShoppingCart.php?q='processPayment' method='POST'>"; 
	echo "<h2>Order Details</h2>"; 
	$nCart = count($_SESSION['cart']); 
	$db = connect(0, 0, 0);
		if(!mysqli_connect_errno()){
		
			for($i = 0; $i < $nCart; $i++){
				$dosage_query = "select * from DOSAGE natural join DOSAGE_DETAILS natural join COMPOUND where dosage_id = ".$_SESSION['cart'][$i]; 
				$result = $db->query($dosage_query); 
				$row = $result->fetch_assoc(); 
				$dosage_id = $row['dosage_id']; $product_id = $row['product_id']; $form = $row['form']; $quantity = $row['quantity']; $image = $row['image']; $price = $row['price']; $value = $row['value']; $metric = $row['metric']; 
				mysqli_free_result($result); 
				$product_query = "select name from PRODUCT where product_id = ".$product_id; 
				$result = $db->query($product_query); 
				$row = $result->fetch_assoc(); 
				$name = $row['name']; 
				mysqli_free_result($result); 
				
				echo "<span class='lineitem'>";
				//echo "<td><img style='width: 50px; height: 50px;' class='thumbs' src='".$image."'></td>"; 
				echo "<label>".$name." ".$form."x".$quantity." - ".$value." ".$metric." each @ $".$price."       Qty: ".$_SESSION['qty'][$i]."</label><br><br>"; 
				//echo "<td><input class='qtyinput' type='text' maxlength='1' name='dosage[]' value='1'></td>";
				echo "</span>"; 
			}
			

		
	//display line items, quantity, order total
	
	//grand total, tax, shipping and handling
	}
	else{ 
			echo "<h1>Could not retrieve cart items due to technical difficulties.</h1>"; 
		}

		echo "<h2>Payment Details</h2>"; 
		//cardfirst, middle, lastname 
		$name[0] = htmlspecialchars(strip_tags($_POST['cardfirstname'])); $name[1] = htmlspecialchars(strip_tags($_POST['cardmiddlename'])); $name[2] = htmlspecialchars(strip_tags($_POST['cardlastname'])); 
		echo "<label><b>Name:</b> ".$name[0]." ".$name[1]." ".$name[2]."</label><br><br>"; 
		//card four1, 2, 3, 4 
		$cardnum[0] = htmlspecialchars(strip_tags($_POST['four1'])); $cardnum[1] = htmlspecialchars(strip_tags($_POST['four2'])); $cardnum[2] = htmlspecialchars(strip_tags($_POST['four3'])); $cardnum[3] = htmlspecialchars(strip_tags($_POST['four4']));  
		echo "<label><b>Card number:</b> ".$cardnum[0]."-".$cardnum[1]."-".$cardnum[2]."-".$cardnum[3]."</label><br>"; 
		//expiration, cardtype 
		$expiration = htmlspecialchars(strip_tags($_POST['expiration'])); $type = htmlspecialchars(strip_tags($_POST['cardtype'])); 
		echo "<label>Expires ".$expiration." Type: ".$type."</label><br><br>"; 
		//street, city, state, zip, apt 
		$street = htmlspecialchars(strip_tags($_POST['street'])); $city = htmlspecialchars(strip_tags($_POST['city'])); $state = htmlspecialchars(strip_tags($_POST['state'])); $zip = htmlspecialchars(strip_tags($_POST['zip'])); $apt = htmlspecialchars(strip_tags($_POST['apt'])); 
		echo "<label><b>Payment Address</b></label><br>"; 
		echo "<label>".$street.", ".$city.", ".$state.", ".$zip." Apt # ".$apt."</label><br><br><br>";
		echo "<a href='ShoppingCart.php?q=cart'>Return to Cart</a><input id='submitbutton' type='submit' value='Process Payment'>"; 
		
	}
	
	function displayCart(){
		@session_start(); 
		
		echo "<h1>Shopping Cart</h1>"; 
		$nCart = count($_SESSION['cart']); 
		echo "<form action='ShoppingCart.php?q=authenticateCart' method='POST'>"; 
		echo "<table>"; 
		echo "<tr style='font-weight: bold;'><td></td><td>Name</td><td>Form</td><td>Qty</td><td>Dosage</td><td>Metric</td><td>Price</td><td>Desired Quantity</td></tr>"; 
		$db = connect(0, 0, 0);
		if(!mysqli_connect_errno()){
		
			for($i = 0; $i < $nCart; $i++){
				$dosage_query = "select * from DOSAGE natural join DOSAGE_DETAILS natural join COMPOUND where dosage_id = ".$_SESSION['cart'][$i]; 
				$result = $db->query($dosage_query); 
				$row = $result->fetch_assoc(); 
				$dosage_id = $row['dosage_id']; $product_id = $row['product_id']; $form = $row['form']; $quantity = $row['quantity']; $image = $row['image']; $price = $row['price']; $value = $row['value']; $metric = $row['metric']; 
				mysqli_free_result($result); 
				$product_query = "select name from PRODUCT where product_id = ".$product_id; 
				$result = $db->query($product_query); 
				$row = $result->fetch_assoc(); 
				$name = $row['name']; 
				mysqli_free_result($result); 
				
				echo "<tr class='lineitem'>";
				echo "<td><img style='width: 50px; height: 50px;' class='thumbs' src='".$image."'></td>"; 
				echo "<td>".$name."</td><td>".$form."</td><td>x".$quantity."</td><td>".$value."</td><td>".$metric."</td><td>".$price."</td>"; 
				echo "<td><input class='qtyinput' type='text' maxlength='1' name='dosage[]' value='1'></td>";
				echo "</tr>"; 
			}
			
			echo "</table>";
			echo "<input id='submitbutton' type='submit' value='Submit'>"; 			
			echo "</form>"; 
			//session_destroy(); 
		}
		else{
			echo "<h1 style='color: red; font-weight: bold; '>Having server difficulties right now. Try again later.</h1>"; 
		}
		
	}
	
	function authenticateCartPOST(){
		@session_start(); 
		
		/*if(isset($_POST['dosage'])){
			echo "<h1>Dosage post is set!"; 
			echo "<h1>Dosage 0 : ".$_POST['dosage'][0]."</h1>"; 
		}*/ 
		
		$nCart = count($_SESSION['cart']); 
		$db = connect(0, 0, 0);
		$availability = array();
		$valid = array(); 
		$valide = array(); 
		$error = array(); 
		
		if(!mysqli_connect_errno()){
			for($i = 0; $i < $nCart; $i++){
				$_SESSION['qty'][$i] = $_POST['dosage'][$i];
				//echo "<p>".$_SESSION['cart']['qty'][$i]."</p>"; 
				
				$dosage_query = "select * from DOSAGE natural join DOSAGE_DETAILS natural join COMPOUND natural join STORE where dosage_id = ".$_SESSION['cart'][$i]; 
				$result = $db->query($dosage_query); 
				$row = $result->fetch_assoc(); 
				$quantity = $row['quantity']; $value = $row['value']; $remaining = $row['remaining']; 
				mysqli_free_result($result); 
				
				if(($_POST['dosage'][$i] * $quantity * $value) > $remaining){
					$availability[$i] = "There is not enough of this item left in stock!";
					$valid[$i] = false; 
				}
				else{
					$availability[$i] = ""; 
					$valid[$i] = true; 
				}
				
				if(empty($_POST['dosage'][$i])){
					$error[$i] = "Please select a quantity for you order!"; 
					$valide[$i] = false; 
				}
				else{
					$valide[$i] = true; 
				}
				
			}
		}
		
		$valid_final = true; 
		for($j= 0; $j < count($valid); $j++){
			if($valid == false){
			$valid_final = false; break; 
			}else{ $valid_final = true; }
			if($valide == false){
			$valid_final = false; break; 
			}else{ $valid_final = true; }
		}
		
		if($valid_final){
			confirmCart(); 
		}
		else{
			displayCart(); 
			for($d = 0; $d < count($availability); $d++){
				echo "<label class='formerror'> Line item ".$d." : ".$availability[$d]."</label><br>"; 
			}
		}
	}
	
	function confirmCart(){
		@session_start(); 
		
		echo "<h1>Confirm Order Details</h1>"; 
		$nCart = count($_SESSION['cart']); 
		echo "<h1>".$nCart."</h1>"; 
		echo "<form action='ShoppingCart.php?q=payment' method='POST'>"; 
		//echo "<table>"; 
		//echo "<tr style='font-weight: bold;'><td></td><td>Name</td><td>Form</td><td>Qty</td><td>Dosage</td><td>Metric</td><td>Price</td><td>Desired Quantity</td></tr>"; 
		$db = connect(0, 0, 0);
		if(!mysqli_connect_errno()){
		
			for($i = 0; $i < $nCart; $i++){
				$dosage_query = "select * from DOSAGE natural join DOSAGE_DETAILS natural join COMPOUND where dosage_id = ".$_SESSION['cart'][$i]; 
				$result = $db->query($dosage_query); 
				$row = $result->fetch_assoc(); 
				$dosage_id = $row['dosage_id']; $product_id = $row['product_id']; $form = $row['form']; $quantity = $row['quantity']; $image = $row['image']; $price = $row['price']; $value = $row['value']; $metric = $row['metric']; 
				mysqli_free_result($result); 
				$product_query = "select name from PRODUCT where product_id = ".$product_id; 
				$result = $db->query($product_query); 
				$row = $result->fetch_assoc(); 
				$name = $row['name']; 
				mysqli_free_result($result); 
				
				echo "<span class='lineitem'>";
				//echo "<td><img style='width: 50px; height: 50px;' class='thumbs' src='".$image."'></td>"; 
				echo "<label>".$name." ".$form."x".$quantity." - ".$value." ".$metric." each @ ".$price."</label><br><br>"; 
				//echo "<td><input class='qtyinput' type='text' maxlength='1' name='dosage[]' value='1'></td>";
				echo "</span>"; 
			}
			
			//echo "</table>";
			echo "<a class='returnlink' href='ShoppingCart.php?q=cart'>Return to Cart</a>"; 
			echo "<input id='submitbutton' type='submit' value='Finish and Pay'>"; 			
			echo "</form>"; 

		}
		else{
			echo "<h1 style='color: red; font-weight: bold; '>Having server difficulties right now. Try again later.</h1>"; 
		}
	}
	
	function processPayment(){
		
	}
?> 