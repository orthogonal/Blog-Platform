<? //index.php
require_once("dblogin.php");
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server);

if ($_POST['reg_name'] != null){
	$username = fix_string($_POST['reg_name']);
	$password = fix_string($_POST['reg_password']);
	$email = fix_string($_POST['reg_email']);
	$fullname = fix_string($_POST['reg_fullname']);
	$query = "INSERT INTO blog_users (username, password, email, realname) VALUES ('$username', '" . sha1($password) . "', '$email', '$fullname')";
	$result = mysql_query($query) or die(mysql_error());
}

if ($_POST['login_name'] != null){
	$name = fix_string($_POST['login_name']);
	$password = fix_string($_POST['login_password']);
	$query = "SELECT * FROM blog_users WHERE username='$name'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	if ($row != null){
		if ($row[2] == sha1($password)){
			setcookie('main', $row[1]);
			header('Location: http://www.lathamcity.com/blog/index.php');
			}
		else
			//Incorrect Password
			;
	}
	else 
		//Incorrect Username
		;
}


echo <<<_HDOC
<!DOCTYPE html>
<html>
<head>
<title>Andy's Blog</title>
<link rel="stylesheet" type="text/css" href="http://www.lathamcity.com/blog/headerstyle.css" />
<link rel="stylesheet" type="text/css" href="http://www.lathamcity.com/blog/toadstyle.css" />
<script src="http://lathamcity.com/_js/jquery-1.7.js"></script>
<script>
$('document').ready(function() {
	$('#register').hide();
	$('#login').hide();
	$('.sheet').hide();
	
	$('.menulinks').click(function(evt) {
		switch($(this).text()){
			case "Register":
				$('.sheet').show();
				$('#register').show();
				evt.preventDefault();
				break;
			case "Login":
				$('.sheet').show();
				$('#login').show();
				evt.preventDefault();
				break;
		}
	});
	
	$('.sheet').click(function() {
		$('.sheet').fadeOut(200);
		$('#register').fadeOut(200);
		$('#login').fadeOut(200);
		//Clear login/register inputs
	});
}); //end ready
</script>
</head>
_HDOC;

require_once("header.php");

$query = "SELECT * FROM blog_posts ORDER BY id DESC";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_row($result);
$query2 = "SELECT * FROM blog_users WHERE id='$row[1]'";
$result2 = mysql_query($query2) or die(mysql_error());
$row2 = mysql_fetch_row($result2);
echo <<<_HDOC
<div class="post">
	<div class="postHeader"><a href='fullpost.php?id=$row[0]'>$row[2]</a></div>
	<div class="postAuthor">Written by $row2[5] at $row[4]</div>
	<div class="postText">$row[3]</div>
</div>
_HDOC;




function fix_string($string)
{return htmlentities(mysqlfix($string));}
function mysqlfix($string)
{if (get_magic_quotes_gpc())
	$string = stripslashes($string);
return mysql_real_escape_string($string);}

mysql_close($db_server);
echo <<<_HDOC

</body>
</html>
_HDOC;
?>