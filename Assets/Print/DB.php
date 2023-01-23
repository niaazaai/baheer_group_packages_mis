<?php 	
	class DB
	{
		public $host;
		public $user ;
		public $pass ;
		public $dbase;
		public $conn ;
		public $result = null ;
		
		function __construct($host='localhost',$user='root',$pass='',$dbase='print') {					
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->dbase = $dbase;	
			$this->conn = new mysqli($host, $user, $pass,$dbase);		
		}
	
		function  query($query){			
			if(!$this->conn->connect_error){
				return $this->result = $this->conn->query($query);
			}
			else{
				die("Connection failed: " . $conn->connect_error);
			}
		}
				
		function  get_data(){			
			if($this->result){				
				return $this->result;
			}			
		}
		
		function  get_row_count(){			
			if($this->result){				
				return mysqli_num_rows($this->result);
			}			
		}
		
		function  close(){			
			if(!$this->conn->connect_error){
				mysqli_close($this->conn);				
			}			
		}	
		
	}
?>