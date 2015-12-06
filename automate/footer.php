<?php 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
/*
	Name: footer.php
	Path: Root/project2/automate/footer.php
	Version: 2
	Function : This script contains copyright information that is displayed on the
	bottom of each page, along with information (to be added) about affiliates 
	and contact info. The script also contains a circuit that retrieves the correct
	path variable depending on the current directory
*/

	if(strpos(getcwd(), "automate") !== false){
	print "</fieldset>
			<ul id='infringe'>
			<li>&copy 2015 Umbrella Corporation</li>
			<li>&reg<img height='50px' width='50px' src='../pictures/umbrella.png'></li>
			</ul> 
			<br>
			<ul id='contributors'> 
			<li><a href='http://www.drugs.com'>Drugs Official</a></li>
			<li><a href='http://www.chemistwarehouse.com>Chemist Warehouse</a></li>
			<li><a href='www.goodrx.com'>Good RX</a></li>
			</ul>
		   </fieldset>";
		   }
	else{
		print "</fieldset>
			<ul id='infringe'>
			<li>&copy 2015 Umbrella Corporation</li>
			<li>&reg<img height='50px' width='50px' src='pictures/umbrella.png'></li>
			</ul> 
			<br>
			<ul id='contributors'> 
			<li><h3>Our Affliates</h3></li>
			<li><a href='http://www.drugs.com'>Drugs Official</a></li>
			<li><a href='http://www.chemistwarehouse.com'>Chemist Warehouse</a></li>
			<li><a href='http://www.goodrx.com'>Good RX</a></li>
			</ul>
		   </fieldset>";
		   
	}
?>