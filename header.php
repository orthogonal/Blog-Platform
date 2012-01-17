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


$isadmin = false;
$cookieparts = null;

if ($_COOKIE['main'] == "")
	echo  "<li class='menulinks'><a href='http://www.lathamcity.com/register.php'>Register</a></li>  
	<li class='menulinks'><a href='http://www.lathamcity.com/login.php'>Login</a></li>";
else{
	$cookieparts = explode('&', $_COOKIE['main']);
	$query = "SELECT * FROM blog_users WHERE id='$cookieparts[1]'";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($result);
	if ($row[3] == 1) $isadmin = true;

	echo "<li class='menulinks'>Welcome $cookieparts[0]</li>";
	echo "<li class='menulinks' class='link'><a href='http://www.lathamcity.com/blog/logout.php'>Logout</a></li>";
	if ($isadmin) echo "<li class='menulinks' class='link'><a href='http://www.lathamcity.com/newpost.php'>New Post</a></li>";
}

echo "<li class='menulinks'>About</li>  </ul>  <div class='clearfix'></div></div>";

echo <<<_HDOC
<div class='sheet'></div>
<div id='register'>
	Register
	<form method="post" action="http://www.lathamcity.com/blog/index.php">
		<table>
		<tr>
			<td>Username: <input type="text" name="reg_name" size="32" maxlength="32" /></td>
		</tr><tr>
			<td>Password: <input type="password" name="reg_password" size="32" maxlength="32" /></td>
		</tr><tr>
			<td>E-mail: <input type="text" name="reg_email" size="32" maxlength="32" /></td>
		</tr><tr>
			<td>Full Name: <input type="text" name="reg_fullname" size="32" maxlength="32" /></td>
		</tr><tr>
			<td><input type="submit" value="Submit" /></td>
		</tr>
		</table>
	</form>
</div>

<div id='login'>
	Login
	<form method="post" action="http://www.lathamcity.com/blog/index.php">
		<table>
		<tr>
			<td>Username: <input type="text" name="login_name" size="32" maxlength="32" /></td>
		</tr><tr>
			<td>Password: <input type="password" name="login_password" size="32" maxlength="32" /></td>
		</tr><tr>
			<td><input type="submit" value="Log in" /></td>
		</tr>
		</table>
	</form>
</div>
_HDOC;
?>