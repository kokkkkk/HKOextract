<?php


$lines = file("http://www.cuhk.edu.hk/english/contact.html");

	echo "<ol>";
for	($i = 0; $i < count($lines); $i++)	{	
	$subject = $lines[$i];
	$pattern = '/[a-z0-9\-]+\@([a-z0-9\-]+\.?)+/';
	

	if (preg_match($pattern, $subject, $matches)){
		echo "<li>".$matches[0]."</li>";
	}

}
	echo "</ol>";
?>
