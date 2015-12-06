<?php 
/*	Name: user.php
	Path: Root/project2/automate/user.php
	Version: 1
	Function : This script contains objects that are used in user registration 
	pages and functions. 
*/
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 
} 

	class product{
		//require("creditcard.php");
		private $product_id = ""; 
		private $category_id = ""; 
		private $name = ""; 
		private $description = ""; 
		private $dosages = array(); 
		private $valid = false; 
		
		function __construct(){}
		function _construct($product_id, $category_id, $name, $description){
			$this->product_id = htmlspecialchars(strip_tags(trim($product_id)));
			//echo "<p>Construct Product ID(".$this->__get('product_id').")</p>"; 
			$this->category_id = htmlspecialchars(strip_tags(trim($category_id)));
			$this->name = htmlspecialchars(strip_tags($name)); 
			$this->description = htmlspecialchars(strip_tags($description));
			$this->setDosages('EXISTING');  
		}
		
		function _default(){
			
			$this->__set('product_id' , findEmptyKey('PRODUCT', 'product_id')); 
			$this->__set('category_id', 0); 
			$this->__set('name', 'TYPE PRODUCT NAME HERE'); 
			$this->__set('description', 'TYPE THE PRODUCT DESCRIPTION HERE'); 
			$this->setDosages('NEW'); 
		}
		
		public function __get($name){
			return $this->$name; 
		}
		
		public function __set($name, $value){
			if($value == 'name' || $value == 'description'){
			$this->$name = htmlspecialchars(strip_tags($value));
			}else{
			$this->$name = htmlspecialchars(strip_tags(trim($value)));
			}			
		}
		
		public function printing(){
			echo "<h2>Product ID: ".$this->__get('product_id')."</h2>"; 
			echo "<h2>(product)Category ID: ".$this->__get('category_id')."</h2>"; 
			echo "<h2>Product name: ".$this->__get('name')."</h2>"; 
			echo "<h2>Description: ".$this->__get('description')."</h2>"; 
			for($i = 0; $i < count($this->dosages); $i++){
			$this->dosages[$i]->printing();
			}
		}
		
		
		public function validate(){
			$a = true; 
			$dos = false; 
			for($i = 0; $i < count($this->dosages); $i++){
				if(!$this->dosages[$i]->validate()){
					$dos = true; 
					break; 
				}
			}
			if(
			!validate($this->product_id, 'index') ||
			!validate($this->category_id, 'index') ||
			!validate($this->name, 'name' ) ||
			!validate($this->description, 'text' ) ||
			!$dos
			){
			$a = false;
			//echo "<p>Turned up false in the OR vliadtor<p>"; 
			}
			
			
			$this->valid = $a;  
		}
		
		public function write(){
			//echo "<p /> entered write</p>"; 
			if($this->valid == false){
				//echo "<h1>Could not write</h1>"; 
				return false; 
			}
			else{
				@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false; 
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB write connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select product_id from PRODUCT'); 
						$num_results = $result->num_rows; 
						$a = $this->__get('product_id');
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($a == $row['product_id']){
								//echo "<p>Product_ID is taken already! Cannot overwrite!</p>"; 
								$db->close(); return false; 
							}
						}
						
						$query = "insert into PRODUCT
						values("
						.$this->__get('product_id').",
						".$this->__get('category_id').",
						'".$this->__get('name')."',
						'".$this->__get('description')."')"; 
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						if(mysql_error()){
							$db->close(); 
							return false; 
						}
						
						/*for($j = 0; $j < count($this->compounds); $j++){
							$this->compounds[$j]->write(); 
						}*/
						
						for($j = 0; $j < count($this->dosages); $j++){
							$this->dosages[$j]->write(); 
						}
						
						@$db->close();
						return true; 
						 
						
					}
			}
		}
		
		public function update($column, $equiv, $value){
			//echo "<p /> entered update</p>"; 
			if($this->valid == false){
				//echo "<h1>Could not update</h1>"; 
				return false; 
			}
			else{
				@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false; 
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB update connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select '.$column.' from PRODUCT');
						//echo $db->affected_rows." is the number of affected rows."; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						if(mysql_errno()){
							//echo "<p>Error</p>"; 
							$db->close(); return false;
						}
							// echo "<p>Update this id : ".$this->__get('user_id')."</p>"; 
							//echo "<p>Column : ".$column."</p>"; 
							//echo "<p>Class variable : ".$equiv."</p>"; 
							//echo "<p>Value : ".$value."</p>"; 
							
				//make sure that this object's id exists
						$result = $db->query('select product_id from PRODUCT'); 
						$num_results = $result->num_rows; 
						$id = $this->__get('product_id'); 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['product_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){echo "<p>Id does not exist!<p>"; $db->close(); return false;} 
						
						$query = "update PRODUCT set ".$column."= '".$value."' where product_id = ".$this->__get('product_id'); 
						$db->query($query); 
						//echo $db->affected_rows." is the number of affected rows."; 
						
						//echo "<p> Query : ".$query."</p>"; 
						if(mysql_error()){
							//echo "<p>Database Read Error Product->update()</p>";
							@$db->close(); 
							return false; 
						}
						
						$this->__set($equiv, $value); 
						
						@$db->close();
						return true; 
						 
						
					}		
			}
		}
		public function read($id){
			@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false;  
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB Product Read connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select product_id from PRODUCT'); 
						$num_results = $result->num_rows; 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['product_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if($a == false){
						//echo "<p>Id does not exist!<p>"; 
						$db->close(); 
						return false;}

							//echo "<p>About to write!</p>"; 
						$query = "select * from PRODUCT where product_id = ".$id; 
						$result = $db->query($query); 
						$row = $result->fetch_assoc(); 
						$this->__set('product_id', $row['product_id']); 
						$this->__set('category_id', $row['category_id']);
						$this->__set('name', $row['name']);
						$this->__set('description', $row['description']);
						$this->setDosages('EXISTING');
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
					}	
		}
	
	/*function getPOST(){
		if(isset($_POST['privilege'])){$this->__set('lvl', $_POST['privilege']); }
			else{$this->__set('lvl', 'COMM'); } 
		if(isset($_POST['email1']) && isset($_POST['email2'])){if($_POST['email1'] == $_POST['email2']){ $this->__set('login', $_POST['email1']); }  } 
			else{$this->__set('login', 'ERROR'); } //add if VALUE = ERROR in validation
		if(isset($_POST['password1']) && isset($_POST['password2'])){if($_POST['password1'] == $_POST['password2']){$this->__set('pass', $_POST['password1']); }}
			else{$this->__set('pass', 'ERROR'); }
		if(isset($_POST['firstname'])){$this->__set('fn', $_POST['firstname']);  } 
			else{$this->__set('fn', 'ERROR'); }
		if(isset($_POST['lastname'])){$this->__set('ln', $_POST['lastname']); }
			else{$this->__set('ln', 'ERROR'); }
		if(isset($_POST['dob'])){$this->__set('created', $_POST['dob']); }
			else{$this->__set('created', 'ERROR'); }
	}*/
	
		function setDosages($option){
			if($option == 'EXISTING'){
			@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false;  
					}
					else{
					
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful Getting Dosages DB read connection</p>"; 
						$db->select_db("UMBRELLA"); 
						//echo "<p>Successful Getting Dosages DB DB select</p>"; 
						//where product_id = '.$this->__get('product_id')
						$result = $db->query("select * from DOSAGE where product_id = ".$this->__get('product_id')); 
						//echo "<p>Successful Getting Dosages DB Query</p>"; 
						$num_results = $result->num_rows; 
						//echo "<p>Number results from dosages query: ".$num_results."</p>"; 
						for($i = 0; $i < $num_results; $i++){
							//echo "<p>Fetching a dosage : ".$i."</p>"; 
							$row = $result->fetch_assoc(); 
							//echo "<p>fetch_assoc... row id : ".$row['dosage_id']."</p>"; 
							$this->dosages[$i] = new dosage();  
							//echo "<p>Error message: ".mysql_error()."</p>";
							$this->dosages[$i]->read($row['dosage_id']);
							
							//echo "<p>The dosage is called : ".$this->dosages[$i]->__get('form')."</p>"; 
						 
						}
						$db->close(); 
						return true; 
						//$db->close();
						}
						
					}
					
					elseif($option == 'NEW'){
						$this->dosages[0] = new dosage(); //FUTURE NOTE, SPECIFY A READ OPTION 
						$this->dosages[0]->_default($this->__get('product_id'));  
						/*$this->dosages[0]->__set('dosage_id', findEmptyKey('DOSAGE', 'dosage_id'));
						$this->dosages[0]->__set('product_id', $this->__get('product_id'));
						$this->dosages[0]->setCompounds('NEW'); */

						return true; 
					}
					else{
						return false; 
					}
				//FUTURE, CREATE ADDITIONAL METHOD THAT ALLOWS THE DEVELOPER TO MANUALLY SET DOSAGES	
		}
		
		function getDosages(){
			return $this->dosages; 
		}
		
		function toAssocArray(){
			$a = array('product_id'=>$this->__get('product_id'), 
				'category_id'=>$this->__get('category_id'), 
				'name'=>$this->__get('name'), 
				'description'=>$this->__get('description')
				); 
			$b = $this->getDosages(); 
			for($i = 0; $i < count($b); $i++){
				$a['dosage']['dosage_id'][] = $b[$i]->__get('dosage_id'); 
				$a['dosage']['form'][] = $b[$i]->__get('form'); 
				$a['dosage']['quantity'][] = $b[$i]->__get('quantity');
				$a['dosage']['image'][] = $b[$i]->__get('image'); 
				$a['dosage']['price'][] = $b[$i]->__get('price'); 
				//start change here
					$c = $b[$i]->getCompounds(); 
					for($j = 0; $j < count($c); $j++){
						//CHANGED IT HERE
						$a['dosage']['compound']['compound_id'][] = $c[$j]->__get('compound_id'); 
						$a['dosage']['compound']['dosage_id'][] = $b[$i]->__get('dosage_id');
						$a['dosage']['compound']['name'][] = $c[$j]->__get('name'); 
						$a['dosage']['compound']['value'][] = $c[$j]->__get('value'); 
						$a['dosage']['compound']['metric'][] = $c[$j]->__get('metric'); 
					}
			}
		
			return $a; 
		}
	
}
	
?> 
