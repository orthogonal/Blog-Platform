<? //index.php
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







mysql_close($db_server);
echo <<<_HDOC

</body>
</html>
_HDOC;
?>