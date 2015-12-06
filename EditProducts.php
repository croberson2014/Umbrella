      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
/*
Name: EditProducts.php
	Version: 1
	Function : This page will list the products as form fields that can be edited, or with buttons that allow them to be edited. 
	The administrator will also be able to add new products or delete old ones. 
*/
@SESSION_START(); 
/*@$_SESSION['loginstatus'] = "IN"; 
@$_SESSION['privilege'] = 'ADMIN'; 
@$_SESSION['username'] = 'robech'; */
($_SESSION['loginstatus']=="IN" && $_SESSION['privilege'] == "ADMIN") ? $redir = false : $redir = true; 
if($redir){header("Location: UserLogin.php");  } 
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>

<link rel='stylesheet' href='HomePage.css'>
<link rel='stylesheet' href='EditProducts.css'>
<script src='plugins/jquery-1.11.3.js'></script>
<script> 
//alert(); 
//sdf('listCategories');
var data; var category =1; var currentproduct=1; 

$.post('automate/product_functions.php', 'q=listCategories&r=1', processResponse); 
$.post('automate/product_functions.php', 'q=getCategoryList&r=1', processResponse); 
$.post('automate/product_functions.php', 'q=getCategory&r=1&s=COMM', processResponse);
$(document).ready(function (){

$('#login').append("<ul style=' float: left; margin-left: 5em; '><button style='background-color: white; font-size: 2em; font-weight: bold; color: black; border: 5px solid blue; ' id='newProduct'>New Product</button><button style='background-color: white; font-size: 2em; font-weight: bold; color: black; border: 5px solid blue; ' id='newDosage'>New Dosage</button></ul>"); 
$('#newDosage').click(function(){
//alert($('#productfocus').val()); 
$.post("automate/product_functions.php", "q=addDosage&r="+currentproduct, processResponse); 
});
$('#newProduct').click(function(){
//alert(category); 
$.post("automate/product_functions.php", "q=addProduct&r="+category, processResponse); 
}); 
$('#delProduct').append("<div><button  id='remProduct'>Remove Product</button><div>"); 
$('#remProduct').click(function (){
//alert(); 
$.post("automate/product_functions.php", "q=removeProduct&r="+currentproduct, processResponse);
}); 
$('#browsephotos').click(function(){
	//$.post('SelectPhoto.php', 'q='+currentproduct, alert());
	uploadPhoto();  
}); 

});  

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
		category = $('#listproducts').find('option:selected').val();
		$.post("automate/product_functions.php", "q=getCategory&r="+$('#listproducts').find('option:selected').val()+"&s=COMM", processResponse);
		});
	}
	else if(process.selector == '#test2'){
		$(process.selector).html(process.content);
		$('.cat_list').change( function(){
			updateProduct($('#productfocus').val(), 'category_id', $('#listcats').find('option:selected').val());
		});
	}
	else if(process.selector == '#product'){
		displayProduct(process.content); 
	}
	else if(process.selector == '#category'){
		alert('Entering #category response selector'); 
		//alert(process.content.name); 
		displayCategory(process.content); 
	}
	else if(process.selector == '#updated'){
		if(process.source == 'updateProduct'){
			$.post('automate/product_functions.php', 'q=getCategory&r='+process.content.cat_id+'&s=COMM', processResponse); 
		}
		//alert(); 
		//alert("Rebound id : " + process.content.id); alert("Rebound column : " + process.content.column); alert("Rebound value : " + process.content.value); 
		//value is already set on the page, change the font color to reflect an update 
		//$('#dosage_'+process.column+''+id).css("color", "red"); 
	}
	else if(process.selector == '#currentproduct'){
		//$(process.selector).attr('src', process.content.filename); 
		//alert(); 
	}
	else if(process.selector == '#dosage'){
		//alert(process.content.dosage_id); 
		$.post('automate/product_functions.php', 'q=getCategory&r='+category+'&s=COMM', processResponse);
	}
	else if(process.selector == '#addProduct'){
	//SEE IF THIS WORKS EVENTUALLY
		//alert(category); 
		//displayProduct(process.content);
		location.reload(true); 
	}
	else if(process.selector == '#deleteProduct'){
		//alert(); 
		$('#deleted').html("&nbspDelete Operation Successful");
		deleteProduct(); 		
	}
	else if(process.selector == '#deleteDosage'){
		//alert(); 
		//deleteProduct(); 		
		$.post('automate/product_functions.php', 'q=getCategory&r='+category+'&s=COMM', processResponse);
	}
	/*else if(process.selector == '#compound'){
		alert(); 
		
	}*/
	else{
		
	}
	
}
function updateProduct(id, column, value){
	//alert($('#productfocus').val()); 
	//alert(id); alert(column);  alert(value);  
	//alert('Entering update product.'); 
	$.post("automate/product_functions.php", "q=updateProduct&r="+id+"&s="+column+"&t="+value,  processResponse); 
}
function updateDosage(id, column, value){
	//alert(column); alert(id); alert(value);  
	$.post("automate/product_functions.php", "q=updateDosage&r="+id+"&s="+column+"&t="+value,  processResponse); 
}

function updateCompound(id, column, value){
		//alert(column); alert(id); alert(value);
		//alert(); 
	//1)Create the function in product_functions 
	//2)Make sure each element has a compound id
	//3)Set up a preliminary element change event
	
	$.post("automate/product_functions.php", "q=updateCompound&r="+id+"&s="+column+"&t="+value,  processResponse); 
}
function deleteProduct(){
	$.post('automate/product_functions.php', 'q=getCategory&r='+category+'&s=COMM', processResponse);
}
function deleteDosage(id){
	//alert(id); 
	$.post("automate/product_functions.php", "q=removeDosage&r="+id, processResponse); 
}
function deleteCompound(){

}

function myFunction(){

	//alert(id);  
	//$.post('automate/product_functions.php', 'q=updateDosage&r='+id+'&s='+attribute+'&t='+value+'',  alert()); 
	//alert("This is the myFunction"); 
}
function displayDosage(d){
//alert("Entered display dosge"); 
var h = []; var k = []; var l = []; var x = ""; 

			var h = []; var k = []; var l= []; 
			//alert("I : "+i); 
			//alert("H : " + h[i] + " K: "+k[i]);  
			x += "<tr class='dosage' ><td><input id='dosage_form"+d.dosage_id+"' onchange=\"('"+d.dosage_id+"', 'form', this.value);\" size='10' class = 'dosage' type='text' value='"+d.form+"' name='form' ></td>";
			x +="<td><input id='dosage_quantity"+d.dosage_id+"' onchange=\"updateDosage('"+d.dosage_id+"', 'quantity', this.value);\" size='10' class = 'dosage' type='text' value='"+d.quantity+"' name='quantity' ></td>"; 
			//onchange=\"updateDosage('"+p.dosage.dosage_id+"', 'form', "+this.value+");\"
			for (var d = 0; d < count(d.compound.compound_id); d++){
							//alert("d: "+d+" g: "+g);
							//alert("dosage id i: " +p.dosage.dosage_id[i] + "	compound id d: " + p.dosage.compound.compound_id[d]);
							if(d.dosage_id == d.compound.dosage_id[d]){
							//alert("SUCCESS dosage id: " +p.dosage.dosage_id[i] + "compound id : " + p.dosage.compound.compound_id[d]);
							h[g] = d.compound.value[d]; 
							k[g] = d.compound.metric[d]; 
							l[g] = d.compound.compound_id[d]; 
							g++; 
							//alert("EOL	d: "+d+" g: "+g);
							}
			}
				
				for(var j = 0; j < g; j++){
				///alert('J : ' +j); 
				x += "<td><input size='10' value='"+h[j]+"' id='compound_value"+l[g]+"' class='dosages'></td>";
				x += "<td><input size='10' value='"+k[j]+"' id='compound_metric"+l[g]+"' class='dosages'></td>";
				//alert(" J " + j + " : H -> " +h[j] + " K -> " + k[j]); 
				 
					if(!((j == 0 && g > 1) || (j == 1 && g> 2))){
						//x += "<td></td>"; 
					}
					
				
					
				}
				
				x+= "<td><input size='10' value='"+d.price+"' id='dosage_price"+d.dosage_id+"' class='dosages'></td>";
				//x += "<td><button action='javascript:this.preventDefault();' type='button' class='delete' onclick=\"$.post(automate/product_functions.php', 'q=removeDosage&r='"+\">Delete</button></td>";  
				//$('#commit'+p.dosage.dosage_id[i]+"").click(alert($(this).parents('tr').attr('id'))); 
			x += "</tr>"; 
			//alert(x);
		//onclick='alert("+p.dosage.dosage_id[i]+")'
		g = 0; h = null; k = null; l = null; 
	
	$('#dosage').append(x);
	
}

function displayProduct(p){
//alert("Entered displayed product"); 
//alert(p.dosage.compound.compound_id[0]); 
	$('#p1').empty(); $('#p1').val(p.name); 
	//$('#itemno').empty(); $('#itemno').html("Item #"+p.product_id); 
	$('#description').empty(); $('#description').val(p.description); 
	$('#dosage').empty();
	$('#description').append("<input type='hidden' id='productfocus' value="+p.product_id+">"); 
	currentproduct = p.product_id; 
	//alert(currentproduct); 
	$('.cat_list').each(function(){
			$(this).removeAttr('selected'); 	
	}); 
	//$('.cat_list option[value='+p.category_id+']').attr('selected',true); 
	//$('#listcats').find('option:selected').val();
	var x;
	//alert(p.dosage.dosage_id.length); 
	var dosage_count = p.dosage.dosage_id.length;
	var compound_count = p.dosage.compound.compound_id.length; 
	//alert(compound_count); 
	//alert(p.dosage.compound.value[0]); 
	currentproduct = p.product_id; 
	$('#currentproduct').attr("src", p.dosage.image[0]);
	$('#photo').html(p.dosage.image[0]);
	var g = 0;
	var h = []; var k = []; var l = [];
	x = "<table>";
	//x += "<tr id='top'><td>Form</td><td>Quantity</td><td colspan='2'>Value</td><td colspan='2'>Metric</td><td colspan = '2'>Edit</td></tr>";  
	 //var help = p.dosage.compound.compound_id; 
	for(var i = 0; i < dosage_count; i++){
			var h = []; var k = []; var l = []; 
			//alert("I : "+i); 
			//alert("H : " + h[i] + " K: "+k[i]);  
			x += "<tr class='dosage'  ><td><input id='dosage_form"+p.dosage.dosage_id[i]+"' onchange=\"updateDosage('"+p.dosage.dosage_id[i]+"', 'form', this.value);\" size='10' class = 'dosage' type='text' value='"+p.dosage.form[i]+"' name='form' ></td>";
			x += "<td><input id='dosage_quantity"+p.dosage.dosage_id[i]+"' onchange=\"updateDosage('"+p.dosage.dosage_id[i]+"', 'quantity', this.value);\" size='10' class = 'dosage' type='text' value='"+p.dosage.quantity[i]+"' name='quantity' ></td>"; 
			//onchange=\"updateDosage('"+p.dosage.dosage_id+"', 'form', "+this.value+");\"
			for (var d = 0; d < compound_count; d++){
							//alert("d: "+d+" g: "+g);
							//alert("dosage id i: " +p.dosage.dosage_id[i] + "	compound id d: " + p.dosage.compound.compound_id[d]);
							if(p.dosage.dosage_id[i] == p.dosage.compound.dosage_id[d]){
							//alert("SUCCESS dosage id: " +p.dosage.dosage_id[i] + "compound id : " + p.dosage.compound.compound_id[d]);
							h[g] = p.dosage.compound.value[d]; 
							k[g] = p.dosage.compound.metric[d]; 
							l[g] = p.dosage.compound.compound_id[d];
							g++; 
							//alert(p.dosage.compound.compound_id[d]);
							//alert("l[g] : "+l[g]); 
							}
			}
				
				for(var j = 0; j < g; j++){
				///alert('J : ' +j); 
				//alert("l[j] : "+l[j]); 
				x += "<td><input size='10' value='"+h[j]+"' id='compound_value"+l[j]+";' onchange=\"updateCompound('"+l[j]+"', 'value', this.value)\" class='dosages'></td>";
				x += "<td><input size='10' value='"+k[j]+"' id='compound_metric"+l[j]+"' onchange=\"updateCompound('"+l[j]+"', 'metric', this.value)\"class='dosages'></td>";
				//alert(" J " + j + " : H -> " +h[j] + " K -> " + k[j]); 
				 
					if(!((j == 0 && g > 1) || (j == 1 && g> 2))){
						//x += "<td></td>"; 
					}
				}
				x+= "<td><input size='10' value='"+p.dosage.price[i]+"' id='dosage_price"+p.dosage.dosage_id[i]+"' onchange=\"updateDosage('"+p.dosage.dosage_id[i]+"', 'price', this.value);\" class='dosages'></td>";
				x += "<td><button action='javascript:this.preventDefault();' type='button' class='delete' onclick=\"deleteDosage("+p.dosage.dosage_id[i]+");\">Delete</button></td>";  
				//$('#commit'+p.dosage.dosage_id[i]+"").click(alert($(this).parents('tr').attr('id'))); 
			x += "</tr>"; 
			/*alert(x);
		//onclick='alert("+p.dosage.dosage_id[i]+")'*/
		g = 0; h = null; k = null; l = null; 
	}
	//onclick=\"alert($(this).parents('tr').attr('id'))\"
	x+= "</table><br>"; 
	$('#dosage').append(x); 
	//$('#currentproduct').attr("src", p.dosage.image[0]); 
	//$('#p4').empty(); 
}

function displayCategory(cat){
alert("Entering displayCategory function!"); 
	$('#cycle').empty(); 
	//var c = $('#listproducts').find(":selected").text();
	$('#cycle').html(cat.name); 
	alert(cat.product[0].dosage.image[0]); 
	
	
	
	displayProduct(cat.product[0]);
	$('#t1').empty(); 
	//alert(cat.product.length); 
	for(var j = cat.product.length - 1 ; j >= 0;  j--){
		//alert("j = "+j+" and the product is "+cat.product[j].name);  
		//alert("With the dosage id : " +cat.product[j].dosage[0].image[0]); 
		//alert("Without the dosage id: " +cat.product[j].dosage.image[0]); 
		$('#t1').prepend("<img src='"+cat.product[j].dosage.image[0] +"' class='thumbs' id='product"+cat.product[j].product_id+"' value="+cat.product[j].product_id+">"); 
		$('#product'+cat.product[j].product_id).attr("onclick" , "$.post('automate/product_functions.php', 'q=getProduct&r="+cat.product[j].product_id+"&s=COMM', processResponse)"); 
		//alert("j = "+j+" and the product is "+cat.product[j].name); 
	}
	
	/*alert("The category id is:"+cat.category_id); 
	alert("The hidden attribute is: "+$('#catfocus').attr('value')); 
	alert("The global variable category is: "+category); */
}

function uploadPhoto(){
	//send the form_description  
	window.location.replace('SelectPhoto.php?q='+currentproduct+'&r='+category); 	
}
</script> 
</head> 
<body> 
<?php require('automate/header.php'); @session_start(); ?> 
<div id='productform'>
<label id='productsearch'>Category Select</label><label id='deleted'></label>
<div id='test'></div><br><br>
<label name='catselect' id='cycle'></label>
<div id='thumbs'>
	<div id='t1'></div>
	<div id='t2'>
	</div>
</div>  
<div id='category'>
	<div id='c1'>
		<label>Name&nbsp </label><input onchange="updateProduct($('#productfocus').val(), 'name', this.value );" type='text' id='p1' value='Name'><div id='delProduct'></div><br><br>
		<label>Category</label><div id='test2'></div><br><br>
	</div>
	<div id='c2'>
	<br><br><br>
	
	</div>	
	
	<div id='c3'>
	
	</div>
<div id='product'>
	
	<div id='p2'> 
		<label>Description</label><br>
		<textarea onchange="updateProduct($('#productfocus').val(), 'description', this.value );" maxlength='500' rows = '10' cols='200' value="" id='description'></textarea>
		<img id='currentproduct' src='umbrella.png'><br><label>Current File : </label><label id='photo'>Photograph</label><br>
		<!-- <form name='upload_form' action="automate/uploadFile.php" method='post' enctype='multipart/form-data'>
		Attach an image: <br> 
		<input type='file' name='filechoice' accept='image/jpeg, image/gif, image/jpg, image/bmp'> 
		<input type='hidden' name ='MAX_FILE_SIZE' value='1000000'>
		<input type='submit' value='Send File'>
		</form> -->
		<button id='browsephotos' >Change the photo</button> 
	  <br>
	  <div id='message'></div> 
	<label>Dosages</label><br>
	</div> 
	
	<div id='p3'>
		
		<div id='p4'>
		<div id='dosage'></div>
		<!--<input type='radio' class='pclass'><br>-->
		</div>
	</div>
</div>
</div> 
</div>
<?php require('automate/footer.php'); ?>
</body> 
</html> 