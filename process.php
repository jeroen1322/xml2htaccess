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
date_default_timezone_set('Europe/Amsterdam');

// Check if the download checkbox is checked.
// If it is checked, download file.
// If there is no filename set, download as xml2htaccess.html.
// If there IS a filename set, download as [user_defined_name].html
// XML input form on index.html.
// $input = $_POST['input'];
// Store uploaded file as $upload

$upload = $_FILES['input']['tmp_name'];

// If there has been an XML file uploaded, execute the code below.
// If not, display an error.

if (@simplexml_load_file($upload) && !preg_match("/. (.xml)$/i", $upload)) {

	// Load contents $upload

	$xml = simplexml_load_file($upload);

	// Count the ammount of <url> nodes. This will detirmine how many time the for loop runs.

	$page = count($xml->url);

	// Get the domain name from the XML string so users don't have to put it in.

	$domain = $xml->url->loc[0];
	if (isset($_POST['checkbox'])) {
		header("refresh:1;url=download.php");
	}

	// What should be taken out of the name

	$replace = array(
		"http://",
		"www.",
		"/",
		".nl",
		".com",
		".net",
		".io",
		"/\s+/"
	);
	$name = str_replace($replace, "", $domain);

	// Add .xml filetype after the name so $name.xml will be downloaded

	$name = "sitemap-" . $name . date('-d-m-y') . ".xml";
	$_SESSION['name'] = $name;

	// Print page list in HTACCESS style and detimine how many pages should be posted.
	// If there are more $pages than there are in the XML file, you will get a list with missing links.
	// Hence why this is automated and doesn't rely on the user to put it in.

	ob_start();
	echo "#Rewrites van oude naar nieuwe website | " . $domain . " | " . date(' d-m-y') . "<br /><br />";
	echo "RewriteEngine On<br />";
	for ($i = 1; $i < $page; $i++) {

		// Get the page path without the domain name.
		// This will be posted after "RewriteRule ^/"in the echo

		$subpage = str_replace($domain, "", $xml->url[$i]->loc);
		$subpage = str_replace('\\', '', $subpage);

		// Echo all the pages in the correct style.

		echo "RewriteRule ^/" . $subpage . "$ [R=301,L] <br />";
	}

	// Save output and save as xml2htaccess.html, or the userdefined name.

	$page = ob_get_contents();
	ob_end_flush();
	$fp = fopen($name, "w");
	fwrite($fp, $page);
	fclose($fp);
}
else {
	echo "ERROR: Er was een fout tijdens het laden van de XML data. Selecteer alstublieft het goede XML bestand";
}
