<?php //header.php
echo "<body>";
require_once("dblogin.php");
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server);

echo <<<_HDOC
	<div id="header">
		Andy's Blog
	</div>
	
	<div id="linkbar">
		<ul id="links">
_HDOC;

if ($_COOKIE['main'] == "")
	echo  "<li class='menulinks'>Register</li>  <li class='menulinks'>Login</li>";
else{
	$cookieparts = explode('&', $_COOKIE['main']);
	echo "<li class='menulinks'>Welcome $cookieparts[0]</li>  <li class='menulinks'>Logout</li>";
}

echo "<li class='menulinks'>About</li>  </ul>  <div class='clearfix'></div></div>";
?>