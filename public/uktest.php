<?php
$key = "eab77d924612d8";
$input = "E143YR";

$ch = curl_init();
$timeout = 5; // set to zero for no timeout

curl_setopt ($ch, CURLOPT_URL, "http://www.nearby.org.uk/api/convert.php?key=$key&p=$input&output=php&want=ll-wgs84");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);

// display file
echo $file_contents;
?>
