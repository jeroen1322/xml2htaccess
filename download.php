<?php
session_start();
$name = $_SESSION['name']; //Get data from $name var in process.php and store it in $name here.

header('Content-Type: application/download');
header('Content-Disposition: attachment; filename='. $name); 
header("Content-Length: " . filesize($name));

//Download file to the user's browser.
$fp = fopen($name, "r");
fpassthru($fp);
fclose($fp);
 
 