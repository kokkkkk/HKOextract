<?php

$servername = "sql310.byethost12.com";
$username = "b12_19676790";
$password = "14goku25ko";
$database = "b12_19676790_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$lines = file("http://www.hko.gov.hk/textonly/v2/forecast/englishwx2.htm");
date_default_timezone_set("Asia/Hong_Kong");
$time=date("Y-m-d G:i:s");


for	($i = 0; $i < count($lines); $i++)	{	
	$subject = $lines[$i];
	$pattern = '/^Air Temperature \: (\-?\d+) degrees Celsius/';
	
	if (preg_match($pattern, $subject, $matches)){
		$temp = $matches[1];
		$query = "INSERT INTO test SET time = '$time', rate = '$temp'";
       
		echo $matches[1];
        
		$result = $conn->query($query);
        
		if($result === false)	{
			echo "Error /_>|";
		}
		else	{
			echo "Successful";
           
		}
	}
}
$row=$conn->query("SELECT* FROM test ORDER BY time");
$row_count=$row->num_rows;
if($row_count>100){
     $del="DELETE FROM test ORDER BY time LIMIT 1";
     $result = $conn->query($del);
}
?>
