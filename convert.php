<?php
//XML input form on index.html.
$input = $_POST['input']; 

//Load the string as XML
$xml = simplexml_load_string($input) or die("Error while loading XML file");

//Count the ammount of <url> nodes. This will detirmine how many time the for loop runs.
$page = count($xml->url);

//Get the domain name from the XML string so users don't have to put it in.
$domein = $xml->url->loc[0];

//Print page list in HTACCESS style and detimine how many pages should be posted.
//If there are more $pages than there are in the XML file, you will get a list with missing links.
//Hence why this is automated.
for($i=1; $i < $page; $i++){
	//Get the page path without the domein name. 
	$subpage = str_replace($domein,"", $xml->url[$i]->loc);
	//Echo all the pages in the HTACCESS style. 
	echo "RewriteRule ^" . $subpage . "$ " . $xml->url[$i]->loc . " [R=301,L] <br>";
}
