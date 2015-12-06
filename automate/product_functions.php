<?php 
/*if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	$x = true; 
} */
		


?>
<?php 
	include('product.php'); 
	include('dosage.php'); 
	include('compound.php'); 
	include('global_functions.php');
	//q = to the optino that you 
	//switchboard(q), or the opposite
	//this should be encrypted or some other dynamic option. The script can determine a random number, and based on the number that is passed the 
	//script will execute, but for now just do it 
	
	//SECURITY VULNERABILITY in parameter! If you use sha1() to encrypt 'q' then you will be able to use that encrypted value as the option on the 
	//switchboard, that way a hacker will have a difficult time even figuring out what the message is about. ****** Of course, that requires some 
	//print work (find the sha1 option then print it, copy and paste it over the switchboard element) If the words are random, such as names of 
	//fruit, or even non-dictionary words, that would really make it annoying to try. 
	
	//The information will be returned as a particular type of element (such as a table), try to just make those elements appear
	//
	?>
	<?php 
	
	@$q = htmlspecialchars(strip_tags($_POST['q'])); 
	@$r = htmlspecialchars(strip_tags($_POST['r'])); 
	@$s = htmlspecialchars(strip_tags($_POST['s'])); 
	@$t = htmlspecialchars(strip_tags($_POST['t'])); 

	/*if($x = true){
		@$q = 0; 
		@$r = 0; 
		@$s = 0; 
		@$t = 0;
	}*/
	//echo "<p>".$name."</p>"; 
	//echo "<p>q : ".$q."</p>"; 
	//@$q = explode('/', $q); 
	//echo "<h1>q[0] : ".$q[0]."</h1>"; 
	//echo "<p>Some stuff and q is : ".$q."</p>";
	@session_start(); 
	
	
	switch($q){
		//case 'test': test(); break; 
		case 'addCategory': addCategory(); break; //send a post to the EditCategories.php
		case 'listCategories' : listCategories($r); break;
		case  'getCategoryList' : getCategoryList($r); break; 
		case 'changeCategory' : changeCategory($q[1]); break; 
		case 'removeCategory': removeCategory($r); break;
		case 'getCategory' : getCategory(intval($r), $s); break; 
		case 'getProduct' : getProduct(intval($r), $s); break;
		case 'addProduct' : addProduct(intval($r)); break; 
		case 'removeProduct' : removeProduct(intval($r)); break; 
		case 'addDosage' : addDosage(intval($r)); break;
		case 'removeDosage' : removeDosage(intval($r)); break;
		case 'updateCategory' : updateCategory(intval($r), $s); break;
		case 'updateProduct' : updateProduct(intval($r), $s, $t); break; 
		case 'updateDosage' : updateDosage(intval($r), $s, $t); break;
		case 'updateCompound': updateCompound(intval($r), $s, $t); break;
		case 'uploadPhoto' : uploadPhoto(intval($r), $s); break; 
		default: return false; break; 
	}
	
	?> 
	<?php
	function test(){
		echo "<h2>This could be an XML specification that your js interprets... but for starters just make it an element. <h2>";
	}
	
	function addCategory(){
		//adds that category to the database
		//grab the new list by using the getCategory('ADMIN') function
		//and then pass that information back to the javascript for display
		$db = connect(0, 0, 0); 
		$result = $db->query("insert into CATEGORY values (".findEmptyKey('CATEGORY', 'category_id').", 
		'DEFAULT NAME', 'TYPE YOUR CATEGORY DESCRIPTION HERE')"); 
		
		$arr = array('selector' => '#addCategory'); 
		
		json_encode($arr); 
		$db->close(); 
	}
	function addProduct($cat_id){
		$p = new product(); 
		$p->_default(); 
		$p->__set('category_id', $cat_id); 
		$p->validate(); 
		$p->write(); 
		
		$arr = array('selector'=>'#addProduct', 
					'content'=>$p->toAssocArray());
	}
	function addDosage($product_id){
	//the image is the same for all dosages of the same product
	//Get needs the product ID, copy the image from another dosage with the same product[0] after
	//creation
			$d = new dosage(); 
			$d->_default($product_id);
			$d->validate(); 
			$d->write();
				$arr = array('selector'=>'#dosage', 
				'content'=>$d->toAssocArray()
				); 
				echo json_encode($arr); 
			
	}
	function removeCategory($id){
		//? the id should be listed as an html attribute for that particular selection, get the attribute of the current selection passed from 
		//the js script along with the
		//make sure the js displays a confirmation before proceeding 
		//with this process
		//be sure to refresh by using getCategory on current category
		//send that back for processing in the javascript 
		$db = connect(0, 0, 0); 
		$category_id = $id; 
		$result = $db->query('delete from CATEGORY where category_id = '.$id); 
		$result = $db->query('select product_id from PRODUCT where category_id = '.$id); 
		$num_results = $result->num_rows; 
		$p = ""; 
		for($i = 0; $i < $num_results; $i++){
			$row = $result->fetch_assoc(); 
			$p[$i] = $row['product_id']; 
		}
		for($j = 0; $j < count($p); $j++){
			removeProduct($p[$j]); 
		}
		
		$arr = array('selector'=>'#removeCategory'); 
		echo json_encode($arr); 
	}
	function removeProduct($id){
		$p = new product(); 
		$p->read($id); 
		$db = connect(0, 0, 0); 
		$db->query('delete from DOSAGE where product_id = '.$p->__get('product_id'));
		for($i = 0; $i < count($p->getDosages()); $i++){
			$db->query('delete from DOSAGE_DETAILS where dosage_id = '.$p->dosages[$i]->__get('dosage_id')); 
		}
		$db->query('delete from PRODUCT where product_id = '.$p->__get('product_id')); 
		$db->close(); 
		$arr = array('selector'=>'#deleteProduct', 
				'content'=>'Almost Done!'); 
		echo json_encode($arr); 
	}
	function removeDosage($id){
		$d = new dosage(); 
		$d->read($id); 
		$db = connect(0, 0, 0); 
		$db->query('delete from DOSAGE where dosage_id = '.$d->__get('dosage_id')); 
		$db->query('delete from DOSAGE_DETAILS where dosage_id = '.$d->__get('dosage_id')); 
		$db->close(); 
		
		$arr = array('selector'=>'#deleteDosage', 
				'content'=>'Almost Done!'); 
		echo json_encode($arr); 
	}
	
	function listCategories($id){
	//echo "<p>Entering listCategories </p>"; 
	//return a drop down of the categories that can be accessed with an onchange event and that contains IDs 
	$db = connect(0, 0, 0); 
	$result = $db->query('select category_id, name from CATEGORY'); 
		$num_results = $result->num_rows; 
		//echo "<p>Entered listCategories() function. NUmber query results: ".$num_results."</p>"; 
		$b =  "<select name='category' class='hell' id='listproducts' >";
		$c = ""; 
		for($i = 0; $i < $num_results; $i++){
		$row = $result->fetch_assoc(); 
		if(intval($row['category_id']) == $id){
		$b .= "<option class='hell' value=".$row['category_id']." selected>".$row['name']."</option>";
		}
		else{
		$b .= "<option class='hell' value=".$row['category_id']." >".$row['name']."</option>";
		}
		
		}
		
		$b .=  "</select>"; 
		
		//send json using json_encode(array), get it in the response
		//echo json_encode('test'); 
		$data = array('selector'=>'#test',
		'content'=>$b 
		); 
		//echo "<p>".$data['selector']."</p>"; 
		//echo "<p>".$data['content']."</p>"; 
		print json_encode($data); 
	}
	function getCategoryList($id){
	//echo "<p>Entering listCategories </p>"; 
	//return a drop down of the categories that can be accessed with an onchange event and that contains IDs 
	$db = connect(0, 0, 0); 
	$result = $db->query('select category_id, name from CATEGORY'); 
		$num_results = $result->num_rows; 
		//echo "<p>Entered listCategories() function. NUmber query results: ".$num_results."</p>"; 
		$b =  "<select name='category' class='cat_list' id='listcats' >";
		$c = ""; 
		for($i = 0; $i < $num_results; $i++){
		$row = $result->fetch_assoc(); 
		if(intval($row['category_id']) == $id){
		$b .= "<option class='cat_list' value=".$row['category_id']." selected>".$row['name']."</option>";
		}
		else{
		$b .= "<option class='cat_list' value=".$row['category_id']." >".$row['name']."</option>";
		}
		
		}
		
		$b .=  "</select>"; 
		
		//send json using json_encode(array), get it in the response
		//echo json_encode('test'); 
		$data = array('selector'=>'#test2',
		'content'=>$b 
		); 
		//echo "<p>".$data['selector']."</p>"; 
		//echo "<p>".$data['content']."</p>"; 
		print json_encode($data); 
	}
	
	function getCategory($id, $privilege){
	// the ID of the category that has been selected as a part of the q argument, make sure that one is seleted in the dropdown that is returned
	//if privilege is = COMM, return one thing, if not, return the other
		//the id is the value of the select/option
		//get the product for each iteration for the selected category
		//Return an array of products
		
		//These products can then be passed to the processMethod
		//which then selects the appropriate support method to 
		//display the products
	$db = connect(0, 0, 0); 
	$result_cat = $db->query('select category_id, name, description from CATEGORY where category_id = '.$id); 
	$row = $result_cat->fetch_assoc(); 
	$a = array('selector'=>'#category', 
				'content' =>array('category_id'=>$row['category_id'],
							'name'=>$row['name'],
							'description'=>$row['description'])
			); 
	if($privilege == 'COMM'){
		//echo "</p>Making it ehre</a>" ;
		if($id == 0){
			$result_products = $db->query('select * from PRODUCT'); 
		}else{
		$result_products = $db->query('select product_id from PRODUCT where category_id = '.$id); 
		}
		$num_results = $result_products->num_rows; 
		$b = array(); 
		for($i = 0; $i < $num_results; $i++){
			//echo "<p>Getting a product</p>"; 
			$row = $result_products->fetch_assoc(); 
			$j = $row['product_id']; 
			$b[$i] = getProduct(intval($j), 'SYSTEM');
			$a['content']['product'][] = $b[$i]->toAssocArray(); 
			//echo "<p>Fetched products : ".$i."</p>"; 
		}
		
		echo json_encode($a); 
	}
	elseif($privilege == 'ADMIN'){
	
	}
	else{
		echo "RETRIEVAL_ERROR"; 
	}
	
	}
	
	function getProduct($id, $privilege){
		//the JSON format of each product is important so that 
		//each data element can be accessed successfully 
		if ($privilege == 'COMM'){
		$p = new product(); 
		$p->read($id); 
		$p->validate(); 
		$a = array('selector'=>'#product', 
		'content'=>$p->toAssocArray()
		);		
		echo json_encode($a); 
		}
		elseif($privilege ==  'ADMIN'){

		}
		elseif($privilege == 'SYSTEM'){
		$p = new product(); 
		$p->read($id); 
		$p->validate(); 
		return $p; 
		}
		else{
		$p = new product(); 
		$p->read($id); 
		$p->validate(); 
		 
		$a = array('selector'=>'#product', 
		'content'=>$p->toAssocArray()
		);		
		print json_encode($a); 
		}
		
	}
	
	function updateCategory($category_id, $value){
	$arr = array('selector'=>'#updateCategory',
					'content'=>array('id' => $product_id, 
								'column' => $column, 
								'value' => $value)
				); 
				
	$db = connect(0, 0, 0); 
	$result = $db->query("update CATEGORY set name = '".$value."' where category_id =".$category_id);
	$db->close(); 
	}
	
	function updateProduct($product_id, $column, $value){
		$arr = array('selector'=>'#updated',
					'content'=>array('id' => $product_id, 
								'column' => $column, 
								'value' => $value)
		); 
		$p = new product(); 
		$p->read($product_id); 
		//$d->__set('valid', true);
		$p->validate(); 
		//id, attribute, value
		//$column, $equiv, $value
		if($column == 'name'){
			$p->update($column, 'name', $value);
		}
		elseif($column == 'description'){
			$p->update($column, 'description', $value); 
		}
		elseif($column == 'category_id'){
			$p->update($column, 'category_id', $value); 
			$arr['content']['cat_id'] = $value;
			$arr['source'] = 'updateProduct'; 
		}
		else{
			return false; 
		}
		
		
		
		echo json_encode($arr); 
	}
	
	function updateDosage($dosage_id, $column, $value){
		$d = new dosage(); 
		$d->read($dosage_id); 
		//$d->__set('valid', true);
		$d->validate(); 
		//id, attribute, value
		//$column, $equiv, $value
		if($column == 'form'){
			$d->update($column, 'form', $value);
		}
		elseif($column == 'quantity'){
			$d->update($column, 'quantity', $value); 
		}
		elseif($column == 'price'){
			$d->update($column, 'quantity', $value); 
		}
		else{
			return false; 
		}
		
		$arr = array('selector'=>'#updated', 
		'content'=>array('id' => $dosage_id, 
					'column' => $column, 
					'value' => $value)
		); 
		
		echo json_encode($arr); 
	}
	function updateCompound($compound_id, $column, $value){
	//FUTURE IMPLEMENTATION
		$c = new compound(); 
		$c->read($compound_id); 
		$c->validate(); 
		if($column == 'name'){
			$c->update($column, 'name', $value); 
		}
		elseif($column == 'metric'){
			$c->update($column, 'metric', $value); 
		}
		elseif($column == 'value'){
			$c->update($column, 'value', $value); 
		}
		else{
			return false; 
		}
		
		$arr = array('selector'=>'#updated', 
					'content'=>array('id'=>$compound_id, 
									'column'=>$column, 
									'value'=>$value)
					); 
		echo json_encode($arr); 
	}
	
	
	
	function getCompound($id, $privilege){
		
	}
	
	function displayCart(){
	
	}
	
	function addToCart(){
	
	}
	
	function removeFromCart(){
	
	}
	
	function uploadPhoto($product_id, $source){
		$db = connect(0, 0, 0); 
		$db->query("update DOSAGE set image='".$source."' where product_id = ".$product_id); 
		$db->close(); 
	}
	
function myUpload() {
//print "The myUpload function has been called!<br>";
   //print "The temporary file name is ".$_FILES['aFile']['tmp_name'];
   if (is_uploaded_file($_FILES['aFile']['tmp_name'])) {
     $fileName = $_FILES['aFile']['tmp_name'];
     //print "<br>The file $fileName was uploaded successfuly";
     $realName = $_FILES['aFile']['name'];
     //print "<br>The real file name is $realName";
     //print "<br>Copying file [$realName] to the uploads-directory";
     move_uploaded_file($_FILES['aFile']['tmp_name'],
       "/home/students/ics325su1514/[insertYourUsername]/uploads/".
       $realName);
   } else {
     //print"<br>Possible file upload attack:".$_FILES['aFile']['name'].".";
   }
}

	?> 