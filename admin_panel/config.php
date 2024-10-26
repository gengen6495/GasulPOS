<?php
		$servername = "localhost"; 
		$username = "root";
		$password = "";
		$dbname = "sop";
		$port = "3306";
		
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
?>