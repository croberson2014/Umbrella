<?php 
/*	form: user.php
	Path: Root/project2/automate/user.php
	Version: 1
	Function : This script contains objects that are used in user registration 
	pages and functions. 
*/
/*if(strpos($_SERVER['REQUEST_URI'], baseform(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 
}*/ 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
	class dosage{
		//require("creditcard.php");
		private $dosage_id = ""; 
		private $product_id = ""; 
		private $compounds = array();  
		private $form = ""; 
		private $quantity = ""; 
		private $image = ""; 
		private $price = ""; 
		private $valid = false; 
		
		function __construct(){}
		function _construct($dosage_id, $product_id, $form, $quantity, $image, $price){
			//echo "<p>The new construct function was called</p>"; 
			$this->dosage_id = htmlspecialchars(strip_tags(trim($dosage_id)));
			$this->product_id = htmlspecialchars(strip_tags(trim($product_id)));
			$this->setCompounds('EXISTING'); 
			$this->form = htmlspecialchars(strip_tags(trim($form))); 
			$this->quantity = htmlspecialchars(strip_tags(trim($quantity))); 
			$this->image = htmlspecialchars(strip_tags($image));
			$this->price = htmlspecialchars(strip_tags(trim($price)));
		}
		function _default($product_id){
		//echo "<p>The new default function was called</p>"; 
			$this->dosage_id = findEmptyKey('DOSAGE', 'dosage_id'); 
			$this->product_id = htmlspecialchars(strip_tags(trim($product_id))); 
			//FOR LATER, UPDATE TO ALLOW FOR COMPOUND SELECTION
			$this->setCompounds('NEW'); 
			//echo "<p>Value = ".$this->compounds[0]->value."</p>"; 
			$this->form = 'default'; 
			$this->quantity = 10; 
			$this->image = 'uploads/Umbrella.jpg'; 
			$this->price = 20.00;
		}
		
		public function __get($name){
			return $this->$name; 
		}
		
		public function __set($name, $value){
		
			if($value == 'image'){
			$this->$name = htmlspecialchars(strip_tags($value));
			}else{
			$this->$name = htmlspecialchars(strip_tags(trim($value)));
			}			
		}
		
		public function printing(){
			//cannot print if it does not have a compound
			echo "<p class='blue'>Dosage ID: ".$this->__get('dosage_id')."</p>"; 
			echo "<p class='blue'>(Dosage) Product ID: ".$this->__get('product_id')."</p>";
				for($i = 0; $i < count($this->compounds); $i++){
				$this->compounds[$i]->printing();
				}
			
			echo "<p class='blue'>Dosage form: ".$this->__get('form')."</p>"; 
			echo "<p class='blue'>Dosage qty: ".$this->__get('quantity')."</p>"; 
			echo "<p class='blue'>Dosage image src: ".$this->__get('image')."</p>"; 
			echo "<p class='blue'>Dosage price: ".$this->__get('price')."</p>"; 
		}
		
		
		public function validate(){
		//echo "<p>Entered dosage validate()</p>"; 
			$a = true; 
			//echo "<p>Count compounds = ".count($this->getCompounds())."</p>"; 
			for($i = 0; $i < count($this->getCompounds()); $i++){
				//echo "<p> i : ".$i."</p>"; 
				
				//echo "<h1>".$this->compounds[$i]->__get('name')."</h1>";
				if(!$this->compounds[$i]->validate()){
				//echo "<h1>The compounds aren't valid!!!</h1>";
				//echo "<h1>".$this->compounds[$i]->__get('name')."</h1>"; 
					$a = true; break; 
					 
				}
				
				
			}
			//echo "<p>Exited dosage validate()</p>"; 
			if(
			!validate($this->dosage_id, 'index') ||
			!validate($this->product_id, 'index') ||
			!validate($this->form, 'name') ||
			!validate($this->quantity, 'decimal' ) ||
			!validate($this->image, 'name' ) || 
			!validate($this->price, 'decimal' || !$a ) 
			){ 
				$a = false; 
			}
			//$this->__get('valid') == true ? $x = "It's valid before the set" : $x = "It's invalid before the set"; 
			//echo "<p>".$x."</p>";
			//echo "<p>Makes it to the end</p>"; 
			$this->__set('valid', $a); 
			//$this->__get('valid') == true ? $x = "It's valid at the end" : $x = "It's invalid at the end"; 
			//echo "<p>".$x."</p>"; 
		}
		
		function write(){
			//echo "<p> entered write</p>"; 
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
						//(address_id, privilege, login, password, firstform, lastform, created) 
						//echo "<p>Successful DB write connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select dosage_id from DOSAGE'); 
						$num_results = $result->num_rows; 
						$a = $this->__get('dosage_id');
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($a == $row['dosage_id']){
								//echo "<p>User_ID is taken already! Cannot overwrite!</p>"; 
								$db->close(); return false; 
							}
						}
						
						$query = "insert into DOSAGE
						values("
						.$this->__get('dosage_id').",
						".$this->__get('product_id').",
						'".$this->__get('form')."',
						".$this->__get('quantity').",
						'".$this->__get('image')."',
						".$this->__get('price').")"; 
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query); 
						if(mysql_error()){
							return false; 
						}
						
						for($z = 0; $z < count($this->compounds); $z++){
						$query = "insert into DOSAGE_DETAILS values(" 
						.$this->__get('dosage_id').", 
						".$this->compounds[$z]->__get('compound_id').")"; 
						$db->query($query); 
						}
						
						if(mysql_error()){
							return false; 
						}
						
						for($j = 0; $j < count($this->compounds); $j++){
							$this->compounds[$j]->write(); 
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
						//(address_id, privilege, login, password, firstform, lastform, created) 
						//echo "<p>Successful DB update connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select '.$column.' from DOSAGE');
						//echo $db->affected_rows." is the number of affected rows."; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						if(mysql_errno()){
							echo "<p>Error</p>"; 
							$db->close(); return false;
							}
							//echo "<p>Update this id : ".$this->__get('dosage_id')."</p>"; 
							//echo "<p>Column : ".$column."</p>"; 
							//echo "<p>Class variable : ".$equiv."</p>"; 
							//echo "<p>Value : ".$value."</p>"; 
							
				//make sure that this object's id exists
						$result = $db->query('select dosage_id from DOSAGE'); 
						$num_results = $result->num_rows; 
						$id = $this->__get('dosage_id'); 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['dosage_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){echo "<p>Id does not exist!<p>"; $db->close(); return false;} 
						
						$query = "update DOSAGE set ".$column."= '".$value."' where dosage_id = ".$this->__get('dosage_id'); 
						$db->query($query); 
						//echo $db->affected_rows." is the number of affected rows."; 
						
						//echo "<p> Query : ".$query."</p>"; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						$this->__set($equiv, $value); 
						
						@$db->close();
						return true; 
						 
						
					}		
			}
		}
		
		function read($id){
			//echo "<p>Entering dosage read function </p>"; 
	
			@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
				//echo "<p>Error message: ".mysql_error()."</p>";
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false;  
					}
					else{
						//(address_id, privilege, login, password, firstform, lastform, created) 
						//echo "<p>Successful connection the dosage read function()!</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select dosage_id from DOSAGE_DETAILS'); 
						$num_results = $result->num_rows; 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['dosage_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if($a == false){
						//echo "<p>Id does not exist!<p>"; 
						$db->close(); 
						return false;} 
						$query = "select * from DOSAGE where dosage_id = ".$id; 
						$result = $db->query($query); 
						$row = $result->fetch_assoc(); 
						$this->__set('dosage_id', $row['dosage_id']); 
						//echo "<p> Sample".$this->__get('dosage_id')."</p>"; 
						$this->__set('product_id', $row['product_id']);
						$this->__set('form', $row['form']);
						//echo "<p>Sample ".$this->__get('form')."</p>";
						$this->__set('quantity', $row['quantity']);
						$this->__set('image', $row['image']);
						$this->__set('price', $row['price']);
						$this->setCompounds('EXISTING'); 
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
		}
	}
	function setCompounds($option){
	if($option == 'EXISTING'){
		
		@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false;  
					} 
					else{
						//(address_id, privilege, login, password, firstname, lastname, created)  
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select * from DOSAGE_DETAILS natural join COMPOUND where dosage_id = '.$this->__get('dosage_id')); 
						$num_results = $result->num_rows; 
						//echo "<p>Number of compounds: ".$num_results."</p>"; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							$this->compounds[$i] = new compound(); 
							$this->compounds[$i]->read($row['compound_id']); 
							//echo "<p>Compound that existed was set</p>"; 
						}
						
						
						$db->close(); return true; 
					}
				}
				elseif($option == 'NEW'){
				@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false;  
					} 
					else{
						
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB read connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select * from COMPOUND where compound_id = 0'); ; 
						$num_results = $result->num_rows; 
						//echo "<p>Number of compounds: ".$num_results."</p>"; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							$this->compounds[$i] = new compound(); 
							$this->compounds[$i]->read($row['compound_id']); 
						}
						//echo "<p>New compounds set</p>"; 
						$db->close(); return true; 
					}
				}
					
					return $this->compounds; 
	}
		function getCompounds(){
			
			if(empty($this->compounds)){
				return false;
			}
			else{
				return $this->compounds;
			}
		}
	
	/*function getPOST(){
		if(isset($_POST['privilege'])){$this->__set('lvl', $_POST['privilege']); }
			else{$this->__set('lvl', 'COMM'); } 
		if(isset($_POST['email1']) && isset($_POST['email2'])){if($_POST['email1'] == $_POST['email2']){ $this->__set('login', $_POST['email1']); }  } 
			else{$this->__set('login', 'ERROR'); } //add if VALUE = ERROR in validation
		if(isset($_POST['password1']) && isset($_POST['password2'])){if($_POST['password1'] == $_POST['password2']){$this->__set('pass', $_POST['password1']); }}
			else{$this->__set('pass', 'ERROR'); }
		if(isset($_POST['firstform'])){$this->__set('fn', $_POST['firstform']);  } 
			else{$this->__set('fn', 'ERROR'); }
		if(isset($_POST['lastform'])){$this->__set('ln', $_POST['lastform']); }
			else{$this->__set('ln', 'ERROR'); }
		if(isset($_POST['dob'])){$this->__set('created', $_POST['dob']); }
			else{$this->__set('created', 'ERROR'); }
	}*/
	
		
		function toAssocArray(){
			$a = array('dosage_id'=>$this->__get('dosage_id'), 
				'product_id'=>$this->__get('product_id'), 
				'form'=>$this->__get('form'), 
				'quantity'=>$this->__get('quantity'), 
				'image'=>$this->__get('image'), 
				'price'=>$this->__get('price')
				); 
					$b = $this->getCompounds(); 
					for($j = 0; $j < count($b); $j++){
						$a['compound']['compound_id'][] = $b[$j]->__get('compound_id'); 
						$a['compound']['dosage_id'][] = $this->__get('dosage_id');
						$a['compound']['name'][] = $b[$j]->__get('name'); 
						$a['compound']['value'][] = $b[$j]->__get('value'); 
						$a['compound']['metric'][] = $b[$j]->__get('metric'); 
					}
			
		
			return $a; 
		}
}
	
?> 
