<? //index.php
echo <<<_HDOC
<!DOCTYPE html>
<html>
<head>
<title>Andy's Blog</title>
<link rel="stylesheet" type="text/css" href="http://www.lathamcity.com/blog/toadstyle.css" />
</head>
<body>
_HDOC;
require_once("dblogin.php");
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server);
$query = "SELECT * FROM blog_users WHERE id = 1";
$result = mysql_query($query) or die(mysql_error());

$testtext = mysql_fetch_row($result);
echo "$testtext[1]";
echo "<br /><br /><div id='testdiv'>Hello</div>";

mysql_close($db_server);
echo "</body></html>";
?>