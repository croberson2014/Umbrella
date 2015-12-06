<?php 
if(strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false){
	header("Location: ../HomePage.php"); 	
} 
class creditcard{
		private $number = ""; 
		private $fn = ""; 
		private $mn = ""; 
		private $ln = ""; 
		private $exp = ""; 
		private $issuer = ""; 
		private $address = new address(); 
		
		function __construct(){}
		function _construct($number, $fn, $mn, $ln, $exp, $issuer, $address){
			$this->number = $number; $this->fn = $fn; $this->ln = $ln; $this->exp = $exp; $this->issuer = $issuer; 
		}
		
		public function __get($name){
			return $this->$name; 
		}
		
		public function __set($name, $value){
			$this->$name = $value; 
		}
		
		public function read($number){
		
		}
		public function write($option){
		
		}
		public function update(){
		
		}
		
		
	}
?> 