<?php
//Name: xml2htaccess
//Author: Jeroen Grooten
//Description and How to: https://github.com/jeroen1322/xml2htaccess

// xml2htaccess is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2 of the License, or
// any later version.
 
// xml2htaccess is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
 
// You should have received a copy of the GNU General Public License
// along with xml2htaccess. If not, see https://www.gnu.org/licenses/gpl-2.0.html.


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
//Hence why this is automated and doesn't rely on the user to put it in.
ob_start();
for($i=1; $i < $page; $i++){
	//Get the page path without the domein name.
	//This will be posted after "RewriteRule ^/"in the echo
	$subpage = str_replace($domein,"", $xml->url[$i]->loc);
	//Echo all the pages in the HTACCESS style. 
	echo "RewriteRule ^/" . $subpage . "$ " . $xml->url[$i]->loc . " [R=301,L] <br>";
}

//Save output and save as xml.html, in the same folder as the script. 
$page = ob_get_contents();
ob_end_flush();
$fp = fopen("xml.html","w");
fwrite($fp,$page);
fclose($fp);
