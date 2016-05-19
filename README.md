#Description
xml2htaccess is a little script that can be used to (kind off) automate the process of telling Google where the files from the old website went to.
The company, where I am an intern, sometimes would need to move an existing website. They would type the whole HTACCESS file, that Google or other Search Engines need to know where all the stuff went.
This script will make that task less time consuming (if it works...).

#How to use
You need to run this on a webserver of course. Otherwise the PHP script will not work.

I have not written a XML-sitemap script (yet) so i use https://www.xml-sitemaps.com. 
There you can enther the URL and it will generate the XML, on the bottom of the page. You can also download it. 
Copy the XML at the bottom of the page and paste it in the field on index.html
Then press "Send".

The script will run and display you a page with the HTACCESS data. Copy this and paste it in to the correct file. Or whatever you want to do with it.
The output will be written to xml.html, on your server. It will also be downloaded to your browser, as xml.html.

#Planned improvements
-Sanitize input

-Write a unit test to test everything 
