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
			setcookie('main', $row[1] . "&" . $row[0]);
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

if ($_POST['newpost_title'] != null){
	if ($_COOKIE['main'] != null){
		$cookieparts = explode('&', $_COOKIE['main']);
		$title = fix_string($_POST['newpost_title']);
		$text = fix_string(nl2br($_POST['newpost_content']));
		$query = "INSERT INTO blog_posts (authorid, title, text) VALUES ('$cookieparts[1]', '$title', '$text')";
		$result = mysql_query($query) or die(mysql_error());
	}
	else //Tell the user to log in
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
	$('#newpost').hide();
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
			case "New Post":
				$('.sheet').show();
				$('#newpost').show();
				evt.preventDefault();
				break;
		}
	});
	
	$('.sheet').click(function() {
		$('.sheet').fadeOut(200);
		$('#register').fadeOut(200);
		$('#login').fadeOut(200);
		$('#newpost').fadeOut(200);
		//Clear login/register inputs
	});
}); //end ready
</script>
</head>
_HDOC;

require_once("header.php");

$query = "SELECT * FROM blog_posts ORDER BY id DESC";
$result = mysql_query($query) or die(mysql_error());

$i = 0;
while ($i++ < 10 && ($row = mysql_fetch_row($result)) != null){
	//Find author
	$query2 = "SELECT * FROM blog_users WHERE id='$row[1]'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$row2 = mysql_fetch_row($result2);
	
	//Find comments
	$query3 = "SELECT * FROM blog_comments WHERE postid='$row[0]'";
	$result3 = mysql_query($query3) or die(mysql_error());
	$numcomments = 0;
	while (mysql_fetch_row($result3) != null)
		$numcomments++;
echo <<<_HDOC
<div class="post">
	<div class="postHeader"><a href='fullpost.php?id=$row[0]'>$row[2]</a></div>
	<div class="postAuthor">Written by $row2[5] at $row[4]</div>
_HDOC;
	echo "<div class='postText'>" . str_replace("&lt;br /&gt;", "<br />", $row[3]) . "</div>";
	echo "<div class='postComments'>$numcomments comment";
	echo (($numcomments == 1) ? "" : "s" );
	echo "</div></div>";
}

if (($row = mysql_fetch_row($result) != null))
		echo "<div id='archivelink'><a href='http://www.lathamcity.com/blog/archive.php'>Archive</a></div>";



function fix_string($string)
{return htmlentities(mysqlfix($string));}
function mysqlfix($string)
{if (get_magic_quotes_gpc())
	$string = stripslashes($string);
return mysql_real_escape_string($string);}

require_once("footer.php");
?>