<?php
	class item{
		private $connection;
		private $table = "items";
		public $id;
		public $name;
		public $price; 
		public $inv_count;

		public function __construct($db){
			$this->connection = $db;
		}

		function get_all(){
			$query = "select * from " . $this->table;
			$run = mysqli_query($this->connection,$query);
			return $run;
		}

		function buy(){
			$query = "select * from " . $this->table . " where name = '".$this->name."'";
			$run = mysqli_query($this->connection,$query);
			return $run;
		}	

		function execute(){
			$query = "update " . $this->table . " set inv_count = inv_count - 1 where name = '".$this->name."'";
			$run = mysqli_query($this->connection,$query);
			return $run;
		}

		function execute_more($amt){
			$query = "update " . $this->table . " set inv_count = inv_count - ". $amt ." where name = '".$this->name."'";
			$run = mysqli_query($this->connection,$query);
			return $run;
		}

	}
?>