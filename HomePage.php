<html> 
<head>
<!-- 
Name: HomePage.php
	Path: Root/project2/HomePage.php
	Version: 2
	Function : This is the first page that is displayed upon navigating to the site, 
	and contains information about the Umbrella Corporation for those that are 
	unfamiliar. 
-->
<meta lang='en'> 
<title>Umbrella</title> 
<link rel='stylesheet' href='General.css'>
<link rel='stylesheet' href='HomePage.css'>
<script type='text/javascript' src='plugins/jquery-1.11.3.js'></script>
</head> 
<body> 

<?php 
	require("automate/header.php"); 
?>
<h2 >About Umbrella...</h2><p id='present'  >Umbrella is the leader in the production, sale and development of pharmaceutical products, not only in the United States, 
but in the world. Our company prides itself on delegating innovative professionals to do research for causes that matter. For ten years running, researchers have been 
fast at work synthesizing solutions that are improving the lives of both patients and working people everywhere... everyday. </p>
<img src='pictures/about/global.jpg' id='globalpic'>
<!-- </fieldset>
</fieldset> --> 
<?php 
	require("automate/footer.php"); 
?>
<script type='text/javascript'>
	$("#innerfield").css("backgroundColor", "black"); 
	$("#innerfield").css("border", "black"); 
	$("#present").css("color", "white"); 
	$("#outerfield").css("marginRight", "6em"); 
	$("h2").css("color", "white"); 
	
	
</script>
</body>
</html> 