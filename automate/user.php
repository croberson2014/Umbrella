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

	class user{
		//require("creditcard.php");
		private $user_id = ""; 
		private $address_id = ""; 
		private $lvl = ""; private $lvl_val = false; 
		private $login = ""; private $login_val = false; 
		private $pass = ""; private $pass_val = false; 
		public $fn = ""; private $fn_val = false; 
		private $ln = ""; private $ln_val = false; 
		private $created = ""; private $created_val = false; 
		private $valid = false; 
		
		function __construct(){}
		function _construct($user_id, $address_id, $lvl, $login, $pass, $fn, $ln, $created){
			$this->user_id = htmlspecialchars(strip_tags(trim($user_id)));
			$this->address_id = htmlspecialchars(strip_tags(trim($address_id))); 
			$this->lvl = htmlspecialchars(strip_tags(trim($lvl))); 
			$this->login = htmlspecialchars(strip_tags(trim($login))); 
			$this->pass = htmlspecialchars(strip_tags(trim($pass))); 
			$this->fn = htmlspecialchars(strip_tags(trim($fn))); 
			$this->ln = htmlspecialchars(strip_tags(trim($ln))); 
			$this->created = htmlspecialchars(strip_tags(trim($created))); 
		}
		
		public function __get($name){
			return $this->$name; 
		}
		
		public function __set($name, $value){
			$this->$name = htmlspecialchars(strip_tags(trim($value))); 
		}
		
		public function printing(){
			echo "<p>".$this->__get('user_id')."</p>"; 
			echo "<p>".$this->__get('address_id')."</p>"; 
			echo "<p>".$this->__get('lvl')."</p>"; 
			echo "<p>".$this->__get('login')."</p>"; 
			echo "<p>".$this->__get('pass')."</p>"; 
			echo "<p>".$this->__get('fn')."</p>"; 
			echo "<p>".$this->__get('ln')."</p>"; 
			echo "<p>".$this->__get('created')."</p>";
		}
		
		
		public function validate(){
			$a = true; 
			if(
			!validate($this->user_id, 'index') ||
			!validate($this->address_id, 'index') ||
			!validate($this->lvl, 'name' ) ||
			!validate($this->login, 'email' ) ||
			!validate($this->pass, 'password' ) || 
			!validate($this->fn, 'name' ) || 
			!validate($this->ln, 'name' ) ||
			!validate($this->created, 'timestamp')
			){ $a = false; }
			$this->valid = $a; 
			return $a; 
		}
		public function write($option){
		if($option == 'OVERWRITE'){
			//echo "<p /> entered write</p>"; 
			if($this->valid == false){
				//echo "<h1 style='color : red'>There was an error processing your request! Please make sure all fields are completed correctly.</h1>"; 
				return false; 
			}
			else{
				@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(1));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false; 
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB write connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select user_id from USER'); 
						$num_results = $result->num_rows; 
						$query = "insert into USER
						values("
						.$this->__get('user_id').",
						".$this->__get('address_id').",
						'".$this->__get('lvl')."',
						'".$this->__get('login')."',
						'".$this->__get('pass')."',
						'".$this->__get('fn')."',
						'".$this->__get('ln')."',
						'".$this->__get('created')."')";
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
						 
						
					}		
			}
		}
		elseif($option == 'STANDARD'){
			if($this->valid == false){
				//echo "<h1 style='color : red'>There was an error processing your request! Please make sure all fields are completed correctly.</h1>"; 
				return false; 
			}
			else{
				@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(1));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false; 
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB write connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select user_id from USER'); 
						$num_results = $result->num_rows; 
						$a = $this->__get('user_id');
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($a == $row['user_id']){
								//echo "<p>User_ID is taken already! Cannot overwrite!</p>"; 
								$db->close(); return false; 
							}
						}
						
						$query = "insert into USER
						values("
						.$this->__get('user_id').",
						".$this->__get('address_id').",
						'".$this->__get('lvl')."',
						'".$this->__get('login')."',
						'".sha1($this->__get('pass'))."',
						'".$this->__get('fn')."',
						'".$this->__get('ln')."',
						'".$this->__get('created')."')";
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
						 
						
					}		
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
						$result = $db->query('select '.$column.' from USER');
						//echo $db->affected_rows." is the number of affected rows."; 
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						if(mysql_errno()){
							//echo "<p>Error</p>"; 
							$db->close(); return false;
						}
							 //echo "<p>Update this id : ".$this->__get('user_id')."</p>"; 
							//echo "<p>Column : ".$column."</p>"; 
							//echo "<p>Class variable : ".$equiv."</p>"; 
							//echo "<p>Value : ".$value."</p>"; 
							
				//make sure that this object's id exists
						$result = $db->query('select user_id from USER'); 
						$num_results = $result->num_rows; 
						$id = $this->__get('user_id'); 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['user_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){echo "<p>Id does not exist!<p>"; $db->close(); return false;} 
						
						$query = "update USER set ".$column."= '".$value."' where user_id = ".$this->__get('user_id'); 
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
						echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false;  
					}
					else{
						//(address_id, privilege, login, password, firstname, lastname, created) 
						//echo "<p>Successful DB read connection</p>"; 
						$db->select_db("UMBRELLA"); 
						$result = $db->query('select user_id from USER'); 
						$num_results = $result->num_rows; 
						$a = false; 
						for($i = 0; $i < $num_results; $i++){
							$row = $result->fetch_assoc(); 
							if($id == $row['user_id']){
								//echo "<p>Exists!</p>"; 
								$a = true; break; 
							}
						}
						if(!is_integer(intval($a))){$a = false;}
						if($a == false){/*echo "<p>Id does not exist!<p>"; */$db->close(); return false;} 
						$query = "select * from USER where user_id = ".$id; 
						$result = $db->query($query); 
						$row = $result->fetch_assoc(); 
						$this->__set('user_id', $row['user_id']); 
						$this->__set('address_id', $row['address_id']);
						$this->__set('lvl', $row['privilege']);
						$this->__set('login', $row['login']);
						$this->__set('pass', $row['password']);
						$this->__set('fn', $row['firstname']);
						$this->__set('ln', $row['lastname']);
						$this->__set('created', $row['created']);
						
						//echo "<p> Query : ".$query."</p>"; 
						$result = $db->query($query);  
						//echo "<p>Error message: ".mysql_error()."</p>"; 
						
						@$db->close();
						return true; 
				}
	}
	
	function getPOST(){
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
	}
	
	function toAssocArray(){
	
	}
	
	/*public function toTableData(){
		$a = "<tr>";
		$a += "<td>".$this->user_id."</td>";
		$a += "<td>".$this->address_id."</td>";
		$a += "<td>".$this->lvl."</td>";
		$a += "<td>".$this->login."</td>";
		$a += "<td>".$this->pass."</td>";
		$a += "<td>".$this->fn."</td>";
		$a += "<td>".$this->ln."</td>";
		$a += "<td>".$this->created."</td>";
		$a += "</tr>"; 
		
		echo($a); 
		return $a; 
	}*/
	
}
	
?> 
