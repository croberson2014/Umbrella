<?php 
/*	Name: demographic.php
	Path: Root/project2/automate/user.php
	Version: 1
	Function : This script contains objects that are used in user registration 
	pages and functions. 
*/
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 

	class demographic{
		//require("creditcard.php");
		private $demographic_id = ""; 
		private $user_id = "";
		private $ethnicity = ""; 
		private $gender = ""; 
		private $illness = "";
		public $dob = "";  
		private $valid = false; 
		
		function __construct(){}
		function _construct($demographic_id, $user_id, $ethnicity, $gender, $illness, $dob){
			$this->demographic_id = htmlspecialchars(strip_tags(trim($demographic_id))); 
			$this->user_id = htmlspecialchars(strip_tags(trim($user_id)));
			$this->ethnicity = htmlspecialchars(strip_tags($ethnicity)); 
			$this->gender = htmlspecialchars(strip_tags($gender)); 
			$this->illness = htmlspecialchars(strip_tags($illness)); 
			$this->dob = htmlspecialchars(strip_tags(trim($dob))); 
		}
		
		public function __get($name){
			return $this->$name; 
		}
		
		public function __set($name, $value){
			$this->$name = htmlspecialchars(strip_tags(trim($value))); 
		}
		
		public function printing(){
			echo "<p>".$this->__get('demographic_id')."</p>";
			echo "<p>".$this->__get('user_id')."</p>"; 
			echo "<p>".$this->__get('ethnicity')."</p>"; 
			echo "<p>".$this->__get('gender')."</p>"; 
			echo "<p>".$this->__get('illness')."</p>"; 
			echo "<p>".$this->__get('dob')."</p>"; 
		}
		
		
		public function validate(){
			$a = true; 
			if(
			!validate($this->demographic_id, 'index') ||
			!validate($this->user_id, 'index') ||
			!validate($this->ethnicity, 'name' ) ||
			!validate($this->gender, 'name' ) ||
			!validate($this->illness, 'text' ) || 
			!validate($this->dob, 'date' ) 
			){$a = false;}
			
			$this->valid = $a; 
			return $a; 
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
						$result = $db->query('select demographic_id from DEMOGRAPHIC'); 
						$num_results = $result->num_rows; 
						$a = $this->__get('demographic_id');
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($a == $row['demographic_id']){
								//echo "<p>Demographic ID is taken already! Cannot overwrite!</p>"; 
								$db->close(); return false; 
							}
						}
						
						$query = "insert into DEMOGRAPHIC
						values("
						.$this->__get('demographic_id').",
						".$this->__get('user_id').",
						'".$this->__get('ethnicity')."',
						'".$this->__get('gender')."',
						'".$this->__get('illness')."',
						'".convert('HTMLDate', 'MySQLDate', $this->__get('dob'))."')"; 
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
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
						$result = $db->query('select '.$column.' from DEMOGRAPHIC');
						//echo $db->affected_rows." is the number of affected rows."; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						if(mysql_errno()){
							echo "<p>Error</p>"; 
							$db->close(); return false;
						}
							// echo "<p>Update this id : ".$this->__get('demographic_id')."</p>"; 
							//echo "<p>Column : ".$column."</p>"; 
							//echo "<p>Class variable : ".$equiv."</p>"; 
							//echo "<p>Value : ".$value."</p>"; 
							
				//make sure that this object's id exists
						$result = $db->query('select demographic_id from DEMOGRAPHIC'); 
						$num_results = $result->num_rows; 
						$id = $this->__get('demographic_id'); 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['demographic_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){echo "<p>Id does not exist!<p>"; $db->close(); return false;} 
						
						$query = "update DEMOGRAPHIC set ".$column."= '".$value."' where demographic_id = ".$this->__get('demographic_id'); 
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
		
		public function read($id){
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
						$result = $db->query('select demographic_id from DEMOGRAPHIC'); 
						$num_results = $result->num_rows; 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['demographic_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){echo "<p>Id does not exist!<p>"; $db->close(); return false;} 
						$query = "select * from DEMOGRAPHIC where demographic_id = ".$id; 
						$result = $db->query($query); 
						$row = $result->fetch_assoc(); 
						$this->__set('demographic_id', $row['demographic_id']); 
						$this->__set('user_id', $row['user_id']);
						$this->__set('ethnicity', $row['ethnicity']);
						$this->__set('gender', $row['gender']);
						$this->__set('illness', $row['illness']);
						$this->__set('dob', $row['dob']);
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
		}
	}
	
	function getPOST(){
		if(isset($_POST['ethnicity'])){$this->__set('ethnicity', $_POST['ethnicity']); }
			else{$this->__set('ethnicity', 'ERROR'); } 
		if(isset($_POST['genderselect'])){ $this->__set('gender', $_POST['genderselect']);  } 
			else{$this->__set('gender', 'ERROR'); } //add if VALUE = ERROR in validation
		if(isset($_POST['ailment'])){$this->__set('illness', $_POST['ailment']); }
			else{$this->__set('illness', 'ERROR'); }
		if(isset($_POST['dob'])){$this->__set('dob', $_POST['dob']);  } 
			else{$this->__set('dob', 'ERROR'); }
	}
	
}
	
?> 
