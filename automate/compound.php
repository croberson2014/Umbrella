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

	class compound{
		//require("creditcard.php");
		private $compound_id = "";
		private $name = ""; 
		private $value = "";  
		private $metric = "";   
		private $valid = false; 
		
		function __construct(){}
		function _construct($compound_id, $name, $value, $metric){
			$this->compound_id = htmlspecialchars(strip_tags(trim($compound_id)));
			$this->name = htmlspecialchars(strip_tags($name)); 
			$this->value = htmlspecialchars(strip_tags($value)); 
			$this->metric = htmlspecialchars(strip_tags(trim($metric))); 
		}
		
		public function __get($name){
			return $this->$name; 
		}
		
		public function __set($name, $thing){
			if($thing == 'name' || $thing == 'value'){
				$this->$name = htmlspecialchars(strip_tags($thing)); 
			}
			$this->$name = htmlspecialchars(strip_tags(trim($thing))); 
		}
		
		public function printing(){
			echo "<p class='red'>Compound ID: ".$this->__get('compound_id')."</p>"; 
			echo "<p class='red'>Compound Name: ".$this->__get('name')."</p>"; 
			echo "<p class='red'>Compound Value: ".floatval($this->__get('value'))."</p>"; 
			echo "<p class='red'>Compound Metric: ".$this->__get('metric')."</p>";
		}
		
		
		public function validate(){
			//echo "<p>Entered compound validate()</p>";
			$a = true; 
			if(
			!validate($this->compound_id, 'index') ||
			!validate($this->name, 'name') ||
			!validate($this->value, 'decimal' ) ||
			!validate($this->metric, 'name' ) 
			){ $a = false; 
			//echo "<p>Global failed </p>";  
			}
			
			
			$this->valid = $a; 
			//echo "<p>Valid ? End of Compound Validate ".($a == true? "A will be detected!" : "A won't be detected")."</p>";
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
						echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false; 
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB write connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select compound_id from COMPOUND'); 
						$num_results = $result->num_rows; 
						$a = $this->__get('compound_id');
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($a == $row['compound_id']){
								//echo "<p>Compound_ID is taken already! Cannot overwrite!</p>"; 
								$db->close(); return false; 
							}
						}
						
						$query = "insert into COMPOUND
						values("
						.$this->__get('compound_id').",
						'".$this->__get('name')."',
						".$this->__get('value').",
						'".$this->__get('metric')."')"; 
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
						 
						
					}		
			}
		}
		
		public function update($column, $equiv, $thing){
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
						$result = $db->query('select '.$column.' from COMPOUND');
						//echo $db->affected_rows." is the number of affected rows."; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						if(mysql_errno()){
							//echo "<p>Error</p>"; 
							$db->close(); return false;
						}
							// echo "<p>Update this id : ".$this->__get('compound_id')."</p>"; 
							//echo "<p>Column : ".$column."</p>"; 
							//echo "<p>Class variable : ".$equiv."</p>"; 
							//echo "<p>Value : ".$thing."</p>"; 
							
				//make sure that this object's id exists
						$result = $db->query('select compound_id from COMPOUND'); 
						$num_results = $result->num_rows; 
						$id = $this->__get('compound_id'); 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['compound_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){
						//echo "<p>Id does not exist!<p>"; 
						$db->close(); return false;} 
						
						$query = "update COMPOUND set ".$column."= '".$thing."' where compound_id = ".$this->__get('compound_id'); 
						$db->query($query); 
						//echo $db->affected_rows." is the number of affected rows."; 
						
						//echo "<p> Query : ".$query."</p>"; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						$this->__set($equiv, $thing); 
						
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
						//echo "<p>Compound_>read()</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select compound_id from COMPOUND'); 
						$num_results = $result->num_rows; 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['compound_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($id))){$a = false;}
						if($a == false){
						//echo "<p>Id does not exist!<p>"; 
						$db->close(); 
						return false;
						} 
						$query = "select * from COMPOUND where compound_id = ".$id; 
						$result = $db->query($query); 
						$row = $result->fetch_assoc(); 
						$this->__set('compound_id', $row['compound_id']); 
						$this->__set('name', $row['name']);
						$this->__set('value', $row['value']);
						$this->__set('metric', $row['metric']);
						
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
		
	
}
	
?> 
