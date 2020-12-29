<?php


$servername = "servername";
$username = "username";
$password = "password";
$database = "database";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



$lines = file("http://www.hko.gov.hk/textonly/v2/forecast/englishwx2.htm");


		$query = "SELECT*FROM test ORDER BY time";
		
		
		$result = $conn->query($query) ;
		
		if ($result === false) {
			echo "Error";
		}
		else {
			$result->data_seek(0);
			while($record=$result->fetch_assoc()){
				echo$record['time']." ".$record['rate']."<br>";
			}
		}
		


?>