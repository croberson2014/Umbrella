<?php if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php");
	}
	?>
<?php 
include('global_functions.php'); 
include('user.php'); 
include('demographic.php'); 

@$q = htmlspecialchars(strip_tags($_POST['q'])); 
@$r = htmlspecialchars(strip_tags($_POST['r'])); 
@$s = htmlspecialchars(strip_tags($_POST['s'])); 
@$t = htmlspecialchars(strip_tags($_POST['t'])); 

switch($q){
	case 'displayUsers' : displayUsers($r); break; 
	case 'updateUser' : updateUser(intval($r), $s, $t); break;  
	case 'deleteUser' : deleteUser(intval($r)); header('location: allusers.php?SHOW'); break; 
	default: break; 
}







function getFormPOST($option){
		//return an array containing a user and a demographic with the post data
		$d = new demographic(); 
		$u = new user(); 
		$d->getPOST(); 
		$u->getPOST(); 
		
		$post[0] = $u; 
		$post[1] = $d; 
		return $post; 
}


function displayUsers($option){
if($option == 'SHOW'){
	$db = connect(0, 0, 0); 
	$result = $db->query("select user_id from USER where privilege='COMM'"); 
	$num_results = $result->num_rows; 
	//echo "<p>".$num_results."</p>"; 
	echo "<table>";
	echo "<tr><td>User ID</td><td>Address ID</td><td>Privilege</td><td>Username</td><td>Password</td><td>First Name</td><td>Last Name</td><td>Created Timestamp</td></tr>"; 
	for($i = 0; $i < $num_results; $i++){
		$row = $result->fetch_assoc(); 
		//echo "<p>Row User ID: ".$row['user_id']."</p>"; 
		$u = new user();
		$u->read($row['user_id']); 
		echo "<tr>";
		echo "<td>".$u->user_id."</td>";
		echo "<td>".$u->address_id."</td>";
		echo "<td>".$u->lvl."</td>";
		echo "<td>".$u->login."</td>";
		echo "<td>".$u->pass."</td>";
		echo "<td>".$u->fn."</td>";
		echo "<td>".$u->ln."</td>";
		echo "<td>".$u->created."</td>";
		echo "</tr>"; 
	}
	echo "</table>"; 
	}
	if($option == 'EDIT'){
	$db = connect(0, 0, 0); 
	$result = $db->query("select user_id from USER where privilege='COMM'"); 
	$num_results = $result->num_rows; 
	//echo "<p>".$num_results."</p>";
	/*action="<?php echo $_SERVER['PHP_SELF'] ?>*/
	echo "<form  method='post'>"; 
	echo "<table>";
	echo "<tr class='alt'><td>Privilege</td><td>Username</td><td>Password</td><td>First Name</td><td>Last Name</td><td>Created Timestamp</td><td colspan='2'>Edit</td></tr>"; 
	
	for($i = 0; $i < $num_results; $i++){
		$row = $result->fetch_assoc(); 
		//echo "<p>Row User ID: ".$row['user_id']."</p>"; 
		$u = new user();
		$u->read($row['user_id']); 
		echo "<tr class='alt'>";
		echo "<td><select class='priv' name='privilege'><option class='priv' name='privilege' value='COMM'>COMM</option><option class='priv' name='privilege' value='ADMIN'>ADMIN</option></select></td>";
		$id = $u->__get('user_id');
		echo "<td><input  onchange=\"updateUser(".$id.", 'login', this.value)\" name='login' type='text' size='40' value='".$u->login."'></td>";
		echo "<td><input onchange=\"updateUser(".$id.", 'password', this.value)\" name='password' type='text' size='40' value='".$u->pass."'></td>";
		echo "<td><input onchange=\"updateUser(".$id.", 'firstname', this.value)\" name='firstname' type='text' size='20' value='".$u->fn."'></td>";
		echo "<td><input onchange=\"updateUser(".$id.", 'lastname', this.value)\" name='lastname' type='text' size='30' value='".$u->ln."'></td>";
		echo "<td><input onchange=\"updateUser(".$id.", 'created', this.value)\" name='created' type='text' size='18' value='".$u->created."'></td>";
		echo "<td><button style=' background-color: black; color: white; border: 2px solid red;' onclick=\"deleteUser(".$id."); $(this).parent().parent().remove()\" type='button' name='deleted'>Delete</button></td>";  
		echo "</tr>";
		//echo "<input size='10' type='hidden' name='userid' value='".$u->user_id."'>";
		//echo "<input size='10' type='hidden' name='addressid' value='".$u->address_id."'>";
		
	}
	
	echo "</table>";
	/*echo "<button 
	style='background-color: 
	blue; font-weight: bold; 
	font-size: 2em; border: 
	2px solid red; 
	color: white;  
	width : 100%; 
	padding: 2em;' 
	type='submit' 
	name='editeduser' 
	value='Commit'>Submit</button>"; */
	echo "</form>"; 
	}
}

function updateUser($id, $column, $value){
	$db = connect(0, 0, 0); 
	$db->query("update USER set ".$column."='".$value."' where user_id=".$id);
	$db->close(); 
} 
function deleteUser($id){
	$db = connect(0, 0, 0); 
	$db->query("delete from USER where user_id=".$id); 
	$db->close(); 
}


function updatePaymentMethod(){

}

function addPaymentMethod(){

}
?> 