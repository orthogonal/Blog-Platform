<? //index.php
echo <<<_HDOC
<!DOCTYPE html>
<html>
<head>
<title>Andy's Blog</title>
<link rel="stylesheet" type="text/css" href="http://www.lathamcity.com/blog/toadstyle.css" />
<script src="http://lathamcity.com/_js/jquery-1.7.js"></script>
<script>
$('document').ready(function() {

}); //end ready
</script>
</head>
<body>
_HDOC;
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

$query = "SELECT * FROM blog_posts ORDER BY id DESC";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_row($result);
echo <<<_HDOC
<div class="post">
	<div class="postHeader">$row[2]</div>
	<div class="postText">$row[3]</div>
</div>
_HDOC;







mysql_close($db_server);
echo <<<_HDOC

</body>
</html>
_HDOC;
?>