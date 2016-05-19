<?php

// Name: xml2htaccess
// Author: Jeroen Grooten

// Description and How to: https://github.com/jeroen1322/xml2htaccess
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
// Start session

session_start();

// Check if the download checkbox is checked.
// If it is checked, download file.
// If there is no filename set, download as xml2htaccess.html.
// If there IS a filename set, download as [user_defined_name].html

if (isset($_POST['checkbox'])) {

	// Activate download.php

	header("refresh:1;url=download.php");

	// Set file name if user put a name in

	if ($_POST['name'] != "") {
		$filename = $_POST['name'];

		// replace spaces in input with underscores.

		$filename = preg_replace('/\s+/', '_', $filename);

		// add .html begind the name, so it wil be [user_defined_name].html

		$name = $filename . ".html";
	}
	else {
		$name = "xml2htaccess.html"; //If there was no name input, use xml2htaccess.html as filename for download file.
	}
}
else {

	// Store the output as xml2htaccess.html on the server
	// If the user doesn't want to download the file.

	$name = "xml2htaccess.html";
}

// So download.php can access $name without including process.php

$_SESSION['name'] = $name;

// XML input form on index.html.

$input = $_POST['input'];

// Load the string as XML

$xml = simplexml_load_string($input) or die("Error while loading XML file");

// Count the ammount of <url> nodes. This will detirmine how many time the for loop runs.

$page = count($xml->url);

// Get the domain name from the XML string so users don't have to put it in.

$domain = $xml->url->loc[0];

// Print page list in HTACCESS style and detimine how many pages should be posted.
// If there are more $pages than there are in the XML file, you will get a list with missing links.
// Hence why this is automated and doesn't rely on the user to put it in.

ob_start();

for ($i = 1; $i < $page; $i++) {

	// Get the page path without the domain name.
	// This will be posted after "RewriteRule ^/"in the echo

	$subpage = str_replace($domain, "", $xml->url[$i]->loc);

	// Echo all the pages in the HTACCESS style.

	echo "RewriteRule ^/" . $subpage . "$ " . $xml->url[$i]->loc . " [R=301,L] <br />";
}

// Save output and save as xml2htaccess.html, or the userdefined name.

$page = ob_get_contents();
ob_end_flush();
$fp = fopen($name, "w");
fwrite($fp, $page);
fclose($fp);
