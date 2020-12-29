<?php


$lines = file("http://www.hko.gov.hk/textonly/v2/forecast/englishwx2.htm");

for($i=0; $i<count($lines); $i++){
	$subject = "$lines[$i]";
	$pattern = '/Air Temperature \: (\-?\d+) degrees Celsius/';
	
	if (preg_match($pattern, $subject, $matches)) {
		echo "Tin Man Toi told me that the temperature is ";
		echo $matches[1];
		echo "&deg;C";
	}
}


?>