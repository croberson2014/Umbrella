<?php 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
class address{
	private $street= ""; 
	private $city = ""; 
	private $state = ""; 
	private $zip = ""; 
	private $apt = ""; 
	
	function __construct(){}
	/*function __construct($street, $city, $state, $zip, $apt){
		$this->street = $street; $this->city = $city; $this->state = $state; $this->zip = $zip; $this-apt = $apt; 
	}*/
	public function __get($name){
			return $this->$name; 
	}
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	
}
?>