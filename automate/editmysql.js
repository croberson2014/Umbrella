alert(); 

function mainAJAX(){
	alert(); 
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest(); 
	}
	else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
	}
	
	xml.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status = 200){
		//this is where the code that needs to be changed goes. Take the xmlhttp.responseText, get all the elements from it (maybe for example, it 
		//literally returns an object that can be displayed, but this is more risky because tags cant be stripped
			document.getElementById('test').innerHTML = xmlhttp.responseText; 
			alert(); 
			
		}
	}
	
	xmlhttp.open("POST", "product_functions.php?q='test'", true); 
	xmlhttp.send(); 
}
/*
function update(opt){

}
function displayCategory(cat){

}
function displayProduct(ID){
	//retrieve the product using AJAX 
	//****Make sure that the correct handles exist in the HTML that is returned so that the jQuery works properly 
	//jQuery: get the product with the attribute that matches the ID
	//Can objects in JS be returned to jQuery? Out of curiousity, just get the object with the attribute or get its ID and then use it for thumb
	//Adding it to the cart could also be handled using AJAX. Just onlick() change the session value, but that has nothing to do with mySQL...
	//it could be embedded in the dosage options as well as the Add to Cart and View Cart Buttons (remove cart is on the shopping cart page)
	//
}
function makeThumb(ID){
	
}
*/