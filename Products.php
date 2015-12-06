<html> 
<head> 
<!--
Name: Products.php
	Path: Root/project2/Products.php
	Version: 1
	Function : This script displays the products page and contains a javascript file
	that controls the image thumbs and displays the products that are currently 
	hardcoded into the javascript. 
	-->
<?php include('automate/product_functions.php'); ?>
<meta lang='en'> 
<title>Umbrella Home</title> 
<link rel='stylesheet' href='HomePage.css'>
<link rel='stylesheet' href='Products.css'>
<script src='plugins/jquery-1.11.3.js'></script>
<script> 
//alert(); 
//sdf('listCategories');
var data; 
$(document).ready(function (){

//$('#formstatus').prepend("<h1>Form status! jQuery functions!</h1>");
$.post('automate/product_functions.php', 'q=listCategories&r=1', processResponse); 
//$.post('project3/automate/product_functions.php', 'q=getProduct&r=0&s=COMM', processResponse); 
$.post('automate/product_functions.php', 'q=getCategory&r=1&s=COMM', processResponse); 
//$('#listproducts').attr("onchange",  "$.post('project3/automate/product_functions.php', 'q=getCategory&r="+$('#listproducts :selected').attr('value')+"&s=COMM', processResponse)");
//$('#listproducts').select($.post("project3/automate/product_functions.php", "q=getCategory&r="+$('#listproducts option:selected').attr('value')+"&s=COMM", processResponse));
});  
/*$('#t1').delegate('.thumbs', 'click', function (){
$.post('project3/automate/product_functions.php', 'q=getProduct&r='+$(this).attr('value')+'&s=COMM', processResponse);
}); */
/*function sdf(str){
        if (window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//there is no reason why the correct text should not be sent back in
				//a JSON, based on the function, send the request, wait for it back 
				//and then send it to the right place on the page. Work on the 
				//sub elements of the page before moving onto the larger elements
				//make sure to test the EditProduct functions as well
                document.getElementById("test").innerHTML = xmlhttp.responseText;
		   }
        }
        xmlhttp.open("POST","project3/automate/product_functions.php?q="+str, true);
		//$('#formstatus').append("<p>About to send :" +str+"</p>"); 
        xmlhttp.send(); 
    
		
	
}*/
function processResponse(data){
//alert("Process Response"); 
//PROBLEM? HAD TO PARSE THE RESPONSE DATA 
	//alert(data); 
	var process = jQuery.parseJSON(data);
	//alert(process.selector); 
	//alert(process.content.dosage.compound.value[1]);	
	if(process.selector == '#test'){
		$(process.selector).html(process.content); 
		//$('#listproducts').attr("onselect",  "$.post('project3/automate/product_functions.php', 'q=getCategory&r="+$('#listproducts').val()+"&s=COMM', processResponse)");
		$('.hell').change( function(){
		$.post("automate/product_functions.php", "q=getCategory&r="+$('#listproducts').find('option:selected').val()+"&s=COMM", processResponse);
		});
	}		
	else if(process.selector == '#product'){
		displayProduct(process.content); 
	}
	else if(process.selector == '#category'){
		//alert('to category'); 
		//alert(process.content.name); 
		displayCategory(process.content); 
	}
	else{
		
	}
	
}
function displayProduct(p){
	$('#p1').empty(); $('#p1').html(p.name); 
	$('#itemno').empty(); $('#itemno').html("Item #"+p.product_id); 
	$('#description').empty(); $('#description').html(p.description); 
	$('#dosage').empty(); 
	var x;
	//alert(p.dosage.dosage_id.length); 
	var dosage_count = p.dosage.dosage_id.length;
	var compound_count = p.dosage.compound.compound_id.length; 
	//alert(compound_count); 
	//alert(p.dosage.compound.value[0]); 
	
						
	var g = 0;
	var h = []; var k = []; 
	for(var i = 0; i < dosage_count; i++){
			var h = []; var k = [];
			//alert("I : "+i); 
			//alert("H : " + h[i] + " K: "+k[i]); 
			x = ""; 
			x = "<input type='radio' class='dosage' text-align='right'>"+p.dosage.form[i]+"x"+p.dosage.quantity[i]+" - "; 
			
			 
			for (var d = 0; d < compound_count; d++){
							//alert("d: "+d+" g: "+g);
							//alert("dosage id i: " +p.dosage.dosage_id[i] + "	compound id d: " + p.dosage.compound.compound_id[d]);
							if(p.dosage.dosage_id[i] == p.dosage.compound.dosage_id[d]){
							//alert("SUCCESS dosage id: " +p.dosage.dosage_id[i] + "compound id : " + p.dosage.compound.compound_id[d]);
							h[g] = p.dosage.compound.value[d]; 
							k[g] = p.dosage.compound.metric[d]; 
							g++; 
							//alert("EOL	d: "+d+" g: "+g);
							}
			}
				
				for(var j = 0; j < g; j++){
				///alert('J : ' +j); 
				x += "<labe> "+h[j]+"</label><label> "+k[j]+"</label>";
				//alert(" J " + j + " : H -> " +h[j] + " K -> " + k[j]); 
				 
					if((j === 0 && g > 1) || (j == 1 && g> 2)){
						x += " / "; 
					}
					
				
					
				}
				
				x+= " <label>"+"each   @  $"+p.dosage.price[i]+"</label>";  
				
			
			x += " </input>"; 
			//alert(x);
		$('#dosage').append(x+"<br>");
		g = 0; h = null; k = null; 
	}

	$('#currentproduct').attr("src", p.dosage.image[0]); 
	//$('#p4').empty(); 
}
function displayCategory(cat){
//this will be in the new JSON format, which should be much easier 
//to recognize
//a lot of this will be unecessary because the data will already be 
//formatted for consumption by the program
	$('#cycle').empty(); 
	//var c = $('#listproducts').find(":selected").text();
	$('#cycle').html(cat.name); 
	//alert(cat.product[0].dosage.image[0]); 
	
	displayProduct(cat.product[0]); 
	$('#t1').empty(); 
	//alert(cat.product.length); 
	for(var j = cat.product.length - 1 ; j >= 0;  j--){
		//alert("j = "+j+" and the product is "+cat.product[j].name);  
		$('#t1').prepend("<img src='"+cat.product[j].dosage.image[0] +"' class='thumbs' id='product"+cat.product[j].product_id+"' value="+cat.product[j].product_id+">"); 
		$('#product'+cat.product[j].product_id).attr("onclick" , "$.post('automate/product_functions.php', 'q=getProduct&r="+cat.product[j].product_id+"&s=COMM', processResponse)"); 
		//alert("j = "+j+" and the product is "+cat.product[j].name); 
	}
}
</script> 
</head> 
<body> 
<!-- <h1 id='title' >Umbrella<img src='umbrella.png' id='logo'></h1><br>
<hr>
<fieldset id='outerfield' class='field'>
<div id='nav_bar'>
<ul><li><a href='HomePage.php'>About</a></li>
<li><a href='Products.php'>Products</a></li></ul>
</div>
<fieldset id='innerfield' class='field'>-->
<?php 
	require("automate/header.php"); 
?>
<form id='productform'> 
<div id='category'>
	<div id='c1'>
		<h1 id='cycle'></h1>
		<h2 id='p1'></h2><br>
	</div>
	<div id='c2'>
	<br><br><br>
	<label id='productsearch'>Category Select</label>	
	<div id='test'></div>
	</div>	
	
	<div id='c3'>
	
	</div>
</div> 
<div id='product'>
	
	<div id='p2'> 
		<p id='itemno'></p>
		<p id='description'></p>
	</div> 
	<div id='p3'>
		<img id='currentproduct' src='umbrella.png'>
		<div id='p4'>
		<div id='dosage'></div>
		<!--<input type='radio' class='pclass'><br>-->
		</div>
		</div>
	</div>
</div> 
<div id='thumbs'>
	<div id='t1'></div>
	<div id='t2'>
	</div>
</div> 
</form>
<!--</fieldset>
</fieldset> -->
<?php 
	require("automate/footer.php"); 
?>
</body>
</html> 