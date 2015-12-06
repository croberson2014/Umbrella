<html> 
<!--
	Name: UserRegistration.php
	Path: Root/project2/UserRegistration.php
	Version: 1
	Function : The html on this page displays the registration form and its elements. 
	The javascript/jQuery validates form elements and displays them stylistically. 
	This form is used for new user registration. 
-->
<head>
<meta lang='en'> 
<title>Testing</title> 
<script type='text/javascript' src='plugins/jquery-1.11.3.js'></script>
<script type='text/javascript' src='plugins/jquery.validate.min.js'></script>
<link rel='stylesheet' href='plugins/jquery-ui.css'>
<link rel='stylesheet' href='UserRegistration.css'>
<link rel='stylesheet' href='HomePage.css'>
<script type='text/javascript' src='plugins/jquery-ui.js'></script> 
<link rel='stylesheet' href='plugins/jquery-ui.min'> 
<script type='text/javascript' src='plugins/jquery-ui.min.js'></script> 
<link rel='stylesheet' href='plugins/jquery-ui.structure.css'>
<link rel='stylesheet' href='plugins/jquery-ui.structure.min.css'>
<link rel='stylesheet' href='plugins/jquery-ui.theme.css'>
<link rel='stylesheet' href='plugins/jquery-ui.theme.min.css'>
</head>
<body>
<?php 
	//require("../automate/header.php"); 
	/*$_SESSION['loginstatus'] = null; 
	$_SESSION['username'] = null; 
	$_SESSION['privilege'] = null;*/
?> 
<?php 
	include('automate/user_functions.php'); 
	include('automate/header.php'); 
if(isset($_POST['submit'])){
	
	//echo "<p>New form posted!</p>"; 
	$u = new user(); 
	$u->getPOST(); 
	if($u->__get('login') == "ERROR" || $u->__get('pass') == 'ERROR' ||
	$u->__get('fn') == "ERROR" || $u->__get('ln') == "ERROR" || 
	$u->__get('created') == "ERROR"){
		echo "<h2 style='color : red; '> There were some errors with your submission. Please make sure you entered everything correctly.</h2>"; 
	}
	else{
	$u->__set('user_id', findEmptyKey('USER', 'user_id')); 
	$u->__set('address_id', 0);  $u->__set('lvl', 'COMM');  
	$u2 = $u; 
	$u->__set('password', sha1($u2->__get('pass')));
	$u2 = null; 
	$d = new demographic(); 
	$d->getPOST(); 
	$d->__set('demographic_id', findEmptyKey('DEMOGRAPHIC', 'demographic_id')); 
	$d->__set('user_id', $u->__get('user_id')); 
	
	if($u->validate() && $d->validate()){
	
	$u->write('STANDARD'); 
	$d->write(); 
	@session_start(); 
	@$_SESSION['username'] = $u->__get('login'); 
	@$_SESSION['loginstatus'] == 'IN'; 
	@$_SESSION['privilege'] = "COMM"; 
	}
	else{
		echo "<h2 style='color : red; '> There were some errors with your submission. Please make sure you entered everything correctly.</h2>";
	}
	
	
	}
}	
?>
<form id='newuserform' name = 'newuserform' class='nestedform'  action="<?php echo "".$_SERVER['PHP_SELF'] ?>" method='post'>
<?php
if(@$_SESSION['loginstatus'] !== "IN"){
print "<div id='form0' class='section'>
	<div><h2 id='namesection'>Who are you?</h2><br><br>";

	if(isset($_POST['firstname'])){if($u->__get('fn') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-enter your first name.</h2>"; }}
	if(isset($_POST['lastname'])){if($u->__get('ln') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-enter your last name.</h2>"; }}
	if(isset($_POST['ailment'])){if($d->__get('illness') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-enter illness last name.</h2>";}}
	
print"<label class='namelabel'>First Name</label><input onchange='clientValidate()' id='firstname' name='firstname' type='text' value='' maxlength='20' class='required error' title='Please enter your name.'><label for='firstname' generated='true' class='error'>Required Field</label><br><br>
	<label class='namelabel'>Last Name</label><input onchange ='clientValidate()' id='lastname' name='lastname' type='text' value='' maxlength='30' class='required' title='Please enter your name.'><label for='lastname' generated='true' class='error'>Required Field</label>
	<br><br>
	<label id='commentlabel'>Illness Details</label><br>
	<textarea maxlength='500' rows='5' cols='50' name='ailment' id='ailment' placeholder='List any known illness or describe the illness(es).'></textarea>
	<br><br>
	</div>
</div><br>
<div id='form1' class='section'>
	<h2 id='demographic'><b>Demographic Information</b></h2>";
if(isset($_POST['ethnicity'])){if($d->__get('ethnicity') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-select your ethnicity.</h2>";}}
if(isset($_POST['dob'])){if($d->__get('dob') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-enter your date of birth.</h2>";}} 
if(isset($_POST['gender'])){if($d->__get('gender') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-select your gender.</h2>";}}
	print" <label id='ethnicitylabel'><b>Race/Ethnicity</b></label><div id='raceselect'>";  
	print "<ul id='racelist'>"; 
		echo "<li><input onclick='radioForm(this)' type='radio' name='ethnicity' class='ethnicity' value='White/Caucasion' checked>White/Caucasion</li>"; 
		echo "<li><input onclick='radioForm(this)' type='radio' name='ethnicity' class='ethnicity' value='Asian/Pacific Islander'>Asian/Pacific Islander</li>"; 
		echo "<li><input onclick='radioForm(this)' type='radio' name='ethnicity' class='ethnicity' value='Black/African American'>Black/African American</li>"; 
		echo "<li><input onclick='radioForm(this)' type='radio' name='ethnicity' class='ethnicity' value='Hispanic/Latino'>Hispanic/Latino</li>"; 
		echo "<li><input onclick='radioForm(this)' type='radio' name='ethnicity' class='ethnicity' value='Alaskan/Native American'>Alaskan/Native American</li>"; 
		//print "<li><label for='ethnicity' generated='true' class='error'>Required Field</label></li> 
		print"</ul>
	</div>
	<br><br>
	<label class='doblabel'>Date of Birth <input id='dob' maxlength='10' name='dob' type='text' class='required date error'></label><label for='dob' generated='true' class='error'>Required Field</label>
	<br><br>
	<label for='gender' class='genderlabel'><b>Gender</b></label>"; 
	print "<div id='datepicker' class='genderselect' name='gender'>
		<ul>"; 
		echo "<li><input onclick='checkForm(this)' type='checkbox' id='male' class='genderselect' name='genderselect' value ='Male' checked>Male</li>";  
		echo "<li><input onclick='checkForm(this)' type='checkbox' id='female' class='genderselect' name='genderselect' value='Female'>Female</li>"; 
		echo "<li><input onclick='checkForm(this)' type='checkbox' id='transgender' class='genderselect' name='genderselect' value='Transgender'>Transgender</li>"; 
		echo "<li><input onclick='checkForm(this)' type='checkbox' id='genderneutral' class='genderselect' name='genderselect' value='Gender Neutral'>Gender Neutral</li>"; 
		/*<!--<li><label for='genderselect' generated='true' class='error'>Required Field</label></li> -->*/
		print"</ul>
	</div>
	<br><br>
	</div>"; 
	/*
	<div id='form2' class='section'>
	<h2 id='cardsection'>Credit Card Information</h2>
	<div>
		<span id='cardname'>
			<label id='cardnamesub' class='cardlabel'><b>Name of Cardholder</b></label><br><br>
			<label class='cardnamelabel'>First Name</label><input maxlength='20' name='cardfirstname'type='text' id='cardfirstname' value=''>
			<label class='cardnamelabel'>Middle Name</label><input maxlength='20' name='cardmiddlename' type='text' id='cardmiddlename' value=''>
			<label class='cardnamelabel'>Last Name</label><input maxlength='20' name='cardlastname' id='cardlastname' value=''>
		</span><br><br><br>
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
	</div>
	<div id='address' class='location'>
		<label id='addresssub'><b>Address</b></label><br><br>
		<label class='addresslabel'>Street</label><input maxlength='20' type='text' id='street' name='street' value=''><br><br>
		<label class='addresslabel'>City</label><input maxlength='30' type='text' id='city' name='city' value=''><br><br>
		<label class='addresslabel'>State</label>
		<select id='state' name='state'>
		<option value="AL" name='state'>Alabama(AL)</option>
	<option value="AK" name='state'>Alaska(AK)</option><option name='state' value="AZ">Arizona(AZ)</option><option name='state' value="AR">Arkansas(AR)</option><option name='state' value="CA">California(CA)</option><option name='state' value="CO">Colorado(CO)</option>
	<option name='state' value="CT">Connecticut(CT)</option><option name='state' value="DE">Delaware(DE)</option><option name='state' value="FL">Florida(FL)</option><option name='state' value="GA">Georgia(GA)</option><option name='state' value="HI">Hawaii(HI)</option>
	<option name='state' value="ID">Idaho(ID)</option><option name='state' value="IL">Illinois(IL)</option><option name='state' value="IN">Indiana(IN)</option><option name='state' value="IA">Iowa(IA)</option><option name='state' value="KS">Kansas(KS)</option>
	<option name='state' value="KY">Kentucky(KY)</option><option name='state' value="LA">Louisiana(LA)</option><option name='state' value="ME">Maine(ME)</option><option name='state' value="MD">Maryland(MD)</option><option name='state' value="MA">Massachusetts(MA)</option>
	<option name='state' value="MI">Michigan(MI)</option><option name='state' value="MN">Minnesota(MN)</option><option name='state' value="MS">Mississippi(MS)</option><option name='state' value="MO">Missouri(MO)</option><option name='state' value="MT">Montana(MT)</option>
	<option name='state' value="NE">Nebraska(NE)</option><option name='state' value="NV">Nevada(NV)</option><option name='state' value="NH">New Hampshire(NH)</option><option name='state' value="NJ">New Jersey(NJ)</option><option name='state' value="NM">New Mexico(NM)</option>
	<option name='state' value="NY">New York(NY)</option><option name='state' value="NC">North Carolina(NC)</option><option name='state' value="ND">North Dakota(ND)</option><option name='state' value="OH">Ohio(OH)</option><option name='state' value="OK">Oklahoma(OK)</option>
	<option name='state' value="OR">Oregon(OR)</option><option name='state' value="PA">Pennsylvania(PA)</option><option name='state' value="RI">Rhode Island(RI)</option><option name='state' value="SC">South Carolina(SC)</option><option name='state' value="SD">South Dakota(SD)</option>
	<option name='state' value="TN">Tennessee(TN)</option><option name='state' value="TX">Texas(TX)</option><option name='state' value="UT">Utah(UT)</option><option name='state' value="VT">Vermont(VT)</option><option name='state' value="VA">Virginia(VA)</option>
	<option name='state' value="WA">Washington(WA)</option><option name='state' value="WV">West Virginia(WV)</option><option name='state' value="WI">Wisconsin(WI)</option><option name='state' value="WY">Wyoming(WY)</option>
		</select>
		<br><br>
		<label class='addresslabel'>Zip Code</label><input maxlength='5' type='text' id='zip' name='zip' value=''>
	</div>
</div>
<br><br>-->*/
if(isset($_POST['email1']) && isset($_POST['email2'])){if($u->__get('login') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-enter your user name.</h2>";}}
if(isset($_POST['password1']) && isset($_POST['password2'])){if($u->__get('pass') == 'ERROR'){ echo "<h2 style = 'color: red;'>Please re-enter your password.</h2>";}}
print "
<div id='form2' class='section'>
	<h2 id='loginsection'>User Name and Password</h2>
	<label class='emaillabel'>E-mail</label><input id='email1' maxlength='40' name='email1' type='text' value='' class='email' class='required email error' title='Please enter a valid email ex. someone@somehwere.com'><label for='email1' generated='true' class='error'>Required Field</label>
	<br><br>
	<label class='emaillabel'>Re-enter E-mail</label><input maxlength='40' id='email2' name='email2' type='text' class='email' value='' class='required email error'><label for='email2' generated='true' class='error'>Required Field</label>
	<br><br>
	<label class='userlabel'>Enter Password</label><input id='password1' maxlength='40' name='password1' type='password' class='required error' value=''><label for='password1' generated='true' class='error'>Required Field</label>
	<br><br>
	<label class='userlabel'>Re-enter Password</label><input id='password2' maxlength='40' name='password2' type='password' class='required error' value=''><label for='password2' generated='true' class='error'>Required Field</label>
	<br><br>
	<input type='submit' value='All Finished' id='submit' name='submit'>
</div>"; 
}
else{
echo "<h1 style='color: blue; '>Your registration was successful. Please enjoy browsing the site!</p>"; 
print "<ul><li>User Level : ".$u->__get('lvl')."</li>
			<li>Username : ".$u->__get('login')."</li>
			<li>Password : ".$u->__get('pass')."</li>
			<li>First name : ".$u->__get('fn')."</li>
			<li>Last name : ".$u->__get('ln')."</li>
			<li>Ethnicity : ".$d->__get('ethnicity')."</li>
			<li>Gender : ".$d->__get('gender')."</li>
			<li>Illness : ".$d->__get('illness')."</li>
			<li>Date of birth : ".$d->__get('dob')."</li>"; 
echo "<a href='../Products.php'>Go to products page</a>"; 
}
?>
</form>
<?php 
if(@$_SESSION['loginstatus'] !== "IN"){
print"<div id='buttongroup'>
<button class='navbutton' id='previous' hidden='true' onclick='navForm(false)'>Previous</button>
<button class='navbutton' id='next' onclick='navForm(true)' hidden='true'>Next</button>
</div>"; 
}

include('automate/footer.php'); 
?>
<script type='text/javascript'>
$.datepicker.setDefaults({
	showOn: "both", 
	buttonImageOnly: true, 
	buttonImage: "calendar.gif", 
	buttonText: "None"
}); 
	$('#dob').datepicker(); 

//$('#namesection').html("New html"); 
var currentPlace = 0; 
var canSubmit = false; 
clientValidate(); 
window.onpageshow = function(){setInterval("clientSubmit()", 200);}
$("#form1").attr("hidden", "true"); 
$("#form2").attr("hidden", "true");
$("#form3").attr("hidden", "true");  
$("#submit").attr("disabled", "disabled"); 
$("#next").removeAttr("hidden");
function navForm(direction){
	if(direction == true){
		$("#form"+currentPlace).attr("hidden", "true"); 
		$("#form"+(currentPlace+1)).removeAttr("hidden");
		if(currentPlace == 0){
			$("#previous").removeAttr("hidden");
		}
		if(currentPlace == 1){
			$("#next").attr("hidden", "true"); 
		}
		if(currentPlace < 2)
		currentPlace++; 
	}
	if(direction == false){
		$("#form"+currentPlace).attr("hidden", "true"); 
		$("#form"+(currentPlace-1)).removeAttr("hidden");
		if(currentPlace == 1){
			$("#previous").attr("hidden", "true"); 
		}
		if(currentPlace == 2){
			$("#next").removeAttr("hidden"); 
		}
		if(currentPlace > 0)
		currentPlace--; 
	}
}
function radioForm(rad){ 
	$(".ethnicity").each(function(){
		if(!(this.getAttribute("value") == rad.getAttribute("value"))){
			this.checked=false; 
		}
	});
}
function checkForm(check){ 
	$(".genderselect").each(function(){
		if(!(this.getAttribute("value") == check.getAttribute("value"))){
			this.checked=false; 
		}
	});
}
function isEmpty(e){
	if(e.getAttribute("value") == ''){
		return true;
	}
	else{
		return false;
	}
}
function clientValidate(){
	$("#newuserform").validate(
	
	);
}
function clientSubmit(){
	//STILL WRONG
	if($("#submit").is(':disabled') == true){ $("#submit").css("opacity", "0.5");}
	var isValid = true; 
	if($("#firstname").val() == '')
		isValid = false; 
	if($("#lastname").val() == '')
		isValid = false; 
	//if($("#dob").attr("value")
	if(!($("#password1").val() == $("#password2").val()))
	{isValid=false;}
	if($("#password1").val() == '' || $("#password2").val() == ''){
		isValid = false; 
	}
	if(isValid){
		$("#submit").css("opacity", "1.0");  
		$("#submit").removeAttr("disabled", "disabled"); 
	}
	else{
		$("#submit").attr("disabled", "disabled" );  
	}
}
</script> 
<?php 
	//require("automate/footer.php"); 
?>
</body>
</html> 
