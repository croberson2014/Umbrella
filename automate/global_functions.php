<?php 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
	function getDBName($option){
		//UMBRELLA 
		if($option == 0){
		return "UMBRELLA"; 
		}
	}
	function getDBUserName($option){
		//UMBRELLA -> SALES 
		if($option == 0){
			return "root"; 
		}
		elseif($option == 1){
			return "SALES"; 
		}
		else{
			return false; 
		}
	}
		
	function getDBPassword($option){
		//0 UMBRELLA -> root = ""
		//1 UMBRELLA -> SALES = 3$56^vP!00X&@
		if($option == 0){
			return ""; 
		}
		elseif($option == 1){
			return "3$56^vP!00X&@"; 
		}
		else{
			return false; 
		}
	}
	
	function connect($user, $pw, $dbname){
		@$db = new mysqli('localhost', getDBUserName($user), getDBPassword($pw), getDBName($dbname));
					if(mysqli_connect_errno()){
						echo "<p>Errorrrss</p>"; 
						@$db->close(); 
						return false; 
					}
					else{
						$db->select_db(getDBName($dbname)); 
						return $db; 
					}
	}
	
	 function findEmptyKey($table, $column){ 
	 $j = false; 
		@$db = new mysqli('localhost', getDBUserName(0), getDBPassword(0), getDBName(0));
					if(mysqli_connect_errno()){
						//echo "<p>Errorrrss</p>"; 
						exit; 
					}
					else{
						$db->select_db("UMBRELLA"); 
						$query = "select ".$column." from ".$table; 
						$result = $db->query($query); 
						$num_result = $result->num_rows; 
						$d = array(); 
						for($i = 0; $i < $num_result; $i++){
							$row = $result->fetch_assoc(); 
							//echo "<p>".$row[$column]."</p>"; 
							$d[$i] = $row[$column]; 
						}
						//echo "<p>Number of results: ".$num_result."</p>"; 
						sort($d); 
						for($z = 0; $z < $num_result; $z++){
							if($z != $d[$z]){
								$j = $z; 
								break; 
							}
						}
						
						if($j == false){
							$j = count($d); 
						}
					}
		
		$db->close(); 
		return $j; 
	 }
	 //OF COURSE, CAN UPDATE VALIDATION SCHEME AT ANY TIME
	 function validate($value, $option){
		//echo "<p>Entered validate()</p>";
		$a = true; 
		$v = "<span>";
		$e = ""; 
		
		switch($option){
		//use intval and the is_integer to verify
		case 'index': 
			$v += "<br><p>Checked index</p>"; 
			empty($value) && !$value == 0 ? $a = false : $a = true;
			if($a == false){
			$e += "<br><p>Index validation error: ".$value."</p>";
			}
		break; 
		
		case 'decimal': 
			$v += "<br><p>Checked decimal</p>"; 
			empty($value) || !floatval($value) ? $a = false : $a = true;
			if($a == false){
			$e += "<br><p>Decimal validation error: ".$value."</p>"; 
			}
		break; 
		
		case 'name' : 
			$v += "<br><p>Checked name</p>";
			(empty($value) || intval($value) || floatval($value)) ?  $a = false : $a = true;  
			if($a == false){
			$e += "<br><p>Name validation error</p>"; 
			} 
		break; 
		
		case 'text' : 
			$v += "<br><p>Checked text</p>";
			empty($value) || !is_string($value) ?  $a = false : $a = true;  
			if($a == false){
			$e += "<br><p>Text validation error</p>"; 
			}
		break; 
		
		case 'email' : 
			$v += "<br><p>Checked email</p>";
			empty($value) || !is_string($value) ?  $a = false : $a = true;  
			if($a == false){
			$e += "<br><p>Email validation error</p>"; 
			}
		break; 
		
		case 'password' : 
			$v += "<br><p>Checked password</p>";
			empty($value) || !is_string($value) ?  $a = false : $a = true;  
			if($a == false){
			$e += "<br><p>Password validation error</p>"; 
			}
		break;  
		
		case 'timestamp' : 
			$v += "<br><p>Checked timestamp</p>";
			empty($value) ?  $a = false : $a = true;  
			if($a == false){
			$e += "<br><p>Timestamp validation error</p>"; 
			}
		break; 
		
		case 'date' : 
			$v += "<br><p>Checked date</p>";
			empty($value) || !is_string($value) ?  $a = false : $a = true;  
			if($a == true){
			$e += "<br><p>Date validation error</p>"; 
			}
		break; 
		
		default : $a = false; 
			//echo "<p>Default case selected at least once</p>";  
			break; 
		}
		$v += "</span>"; 
		//echo $v; 
		//echo $e; 
		return $a; 
	 }
	 
	 function convert($option1, $option2, $value){
		//pulling from DB
		$a = ""; 
		if($option1 == 'MySQLDate' && $option2 == 'PHPUnixTimestamp'){ 
		$value = explode('-', $value); 
			$a = mktime(0, 0, 0, $value[1], $value[2], $value[0]); 
		}
		//Writing to DB
		elseif($option1 == 'PHPUnixTimestamp' && $option2 == 'MySQLDate' ){
			$a =  date('Y-m-d', $value); 
		}
		//pulling from DB
		elseif($option1 == 'MySQLTimestamp' && $option2 == 'PHPUnixTimestamp'){
			$value = explode(' ', $value); 
			$date = explode('-', $value[0]); 
			$time = explode(':', $value[1]); 
			$a = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]); 
		}
		//writing to database
		elseif($option1 == 'PHPUnixTimestamp' && $option2 == 'MySQLTimestamp'){
			$a = strftime('%Y-%m-%d %H:%M:%S' , $value); 
		}
		elseif($option1 == 'HTMLDate' && $option2 == 'MySQLDate'){
			$value = explode('/', $value);  
			$a = date('Y-m-d', mktime(0, 0, 0, $value[0], $value[1], $value[2]) );
		}
		
		else{
			$a = false; 
		}
		return $a; 
	 }
	 
	 

?> 