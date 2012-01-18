<?php //fullpost.php

require_once("dblogin.php");
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
mysql_select_db($db_database, $db_server);

$postid = $_GET['id'];
if ($postid == '') header('Location: http://www.lathamcity.com/blog/index.php');

$comment = fix_string(nl2br($_POST['comment']));
if ($comment != ''){
	if ($_COOKIE['main'] != ""){
		$cookievals = explode("&", $_COOKIE['main']);
		$query = "INSERT INTO blog_comments (userid, text, postid) VALUES ('$cookievals[1]', '$comment', '$postid')";
		$result = mysql_query($query) or die(mysql_error());
		header("Location: http://www.lathamcity.com/blog/fullpost.php?id=$postid");
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

$query = "SELECT * FROM blog_posts WHERE id='$postid'";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_row($result);
if ($row == null) die("<div style='text-align: center; font-size: 2em;'>That post does not exist!</div>");
$query2 = "SELECT * FROM blog_users WHERE id='$row[1]'";
$result2 = mysql_query($query2) or die(mysql_error());
$row2 = mysql_fetch_row($result2);
echo <<<_HDOC
<div class="post">
	<div class="postHeader">$row[2]</div>
	<div class="postAuthor">Written by $row2[5] at $row[4]</div>
	<div class="postText">$row[3]</div>
	<div class="commentBox">
_HDOC;

if ($_COOKIE['main'] == "")
	echo "Please register or login to comment on this post";
else{
	echo "Please leave a comment!<br />";
	echo "<form method='post' action='http://www.lathamcity.com/blog/fullpost.php?id=$postid'>";
	echo "<table><tr><td><textarea name='comment' cols='100' rows='8'></textarea></td></tr><tr><td><input type='submit' value='Submit' /></td></tr></table></form>";
}
echo "</div>";

$query = "SELECT * FROM blog_comments WHERE postid='$postid' ORDER BY id ASC";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_row($result);
while ($row != null){
	$query2 = "SELECT * FROM blog_users WHERE id='$row[1]'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$row2 = mysql_fetch_row($result2);
	echo "<div class='comment'>$row2[5] at $row[5]:<br />" . str_replace("&lt;br /&gt;", "<br />", $row[2]) . "</div>";
	$row = mysql_fetch_row($result);
}

echo <<<_HDOC
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