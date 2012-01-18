<?php //archive.php
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

echo "<div id='archivediv'>";
$query = "SELECT * FROM blog_posts ORDER BY time DESC";
$result = mysql_query($query) or die(mysql_error());
$row = null;
while (($row = mysql_fetch_row($result)) != null)
	echo "<a href='http://www.lathamcity.com/blog/fullpost.php?id=$row[0]' style='display: block;'>$row[2]</a>";
echo "</div>";

require_once("footer.php");
?>