<?php
	class db{
		private $host = "localhost";
		private $dbname = "store";
		private $user = "root";
		private $pass = "";
		public $connect;

		public function connect(){
			$this->connect = mysqli_connect($this->host,$this->user,$this->pass,$this->dbname);
			if(!$this->connect){
				echo "Can't connect to network. (". mysqli_connect_errno() . PHP_EOL . ": ".mysqli_connect_error() . PHP_EOL .")";
			}
			return $this->connect;
		}
	}

	//$database = new db();
	//$db = $database->connect();

?>