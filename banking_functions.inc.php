<?php # Script 11.2 - login_functions.inc.php

// This page defines two functions used by the login/logout process.

/* This function determines and returns an absolute URL.
 * It takes one argument: the page that concludes the URL.
 * The argument defaults to index.php.
 */
function absolute_url ($page = 'bank_edit.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Return the URL:
	return $url;

} // End of absolute_url() function.