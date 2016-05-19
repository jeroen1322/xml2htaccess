<?php
header('Content-Type: application/download');
header('Content-Disposition: attachment; filename="xml.html"');
header("Content-Length: " . filesize("xml.html"));

//Download xml.html to the user's browser.
$fp = fopen("xml.html", "r");
fpassthru($fp);
fclose($fp);
 
 