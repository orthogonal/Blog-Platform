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
	echo  "<li class='menulinks'><a>Register</a></li>  <li class='menulinks'><a>Login</a></li>";
else{
	$cookieparts = explode('&', $_COOKIE['main']);
	echo "<li class='menulinks'>Welcome $cookieparts[0]</li>  <li class='menulinks' class='link'>Logout</li>";
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