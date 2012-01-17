<?php //fullpost.php
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
	
	$('.menulinks').click(function() {
		alert($(this).text());
		switch($(this).text()){
			case "Register":
				$('.sheet').show();
				$('#register').show();
				break;
			case "Login":
				$('.sheet').show();
				$('#login').show();
				break;
		}
	});
	
	$('.sheet').click(function() {
		$('.sheet').fadeOut(200);
		$('#register').fadeOut(200);
		$('#login').fadeOut(200);
		//We need to clear the inputs for login and register here
	});
}); //end ready
</script>
</head>
_HDOC;

$postid = $_GET['id'];
if ($postid == '') echo "<script> $('document').ready(function() {window.location.replace('http://lathamcity.com/blog/index.php');});</script>";


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

if ($_COOKIE['main'] == "") echo "Please register or login to comment on this post";
else echo "Please leave a comment!<br />";

echo "</div>";

$query = "SELECT * FROM blog_comments WHERE postid='$postid' ORDER BY id ASC";
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_row($result);
while ($row != null){
	$query2 = "SELECT * FROM blog_users WHERE id='$row[1]'";
	$result2 = mysql_query($query2) or die(mysql_error());
	$row2 = mysql_fetch_row($result2);
	echo "<div class='comment'>$row2[5] at $row[5]:<br />$row[2]</div>";
	$row = mysql_fetch_row($result);
}

echo <<<_HDOC
</div>
_HDOC;







mysql_close($db_server);
echo <<<_HDOC

</body>
</html>
_HDOC;
?>