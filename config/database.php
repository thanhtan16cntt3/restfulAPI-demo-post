<?php 
	/**
	 * 
	 */
	class database
	{
		private $conn;

		private $host = 'localhost';
		private $db_name = 'blog';
		private $username = 'root';
		private $password = 'root';


		public function connect()
		{
			$this->conn = null;

			try{
				$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
				
				// set the PDO error mode to exception
  				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				echo 'Connection Error: '.$e->getMessage;
			}

			return $this->conn;
		}
	}
?>