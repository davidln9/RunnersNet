<!DOCTYPE html>
<html>
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>	
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Account Setup</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
</div>
</header>
<body>
<center>
<div class="namediv">
<form id="infoform" name="infoform" method="post" action="getuserinfo.php">
<h2>Tell us about yourself</h2>
<p>Write a short biography that<br>will appear on your page</p><br>
<textarea type="biography" name="txtBio" id="txtBio" class="inputtext" rows="6" cols="25"></textarea><br>
<input type="submit" name="btnSubmitBio" id="btnSubmitBio">
</form>
</div>
</center>
</body>
</html>
