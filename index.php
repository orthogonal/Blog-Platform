<? //index.php
require_once("dblogin.php");
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server);
$query = "SELECT * FROM blog_users WHERE id = 1";
$result = mysql_query($query) or die(mysql_error());

$testtext = mysql_fetch_row($result);
echo "$testtext[1]";
?>