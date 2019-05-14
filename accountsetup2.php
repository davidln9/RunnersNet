<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
<link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Account Setup</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
    echo "<a href='#' class='headname'>".$uname."</a>";
?>
</div>
</header>
<body>
<center>
<div class="distancediv">
<form id="infoform" name="infoform" method="post" action="getuserinfo.php">
<p>Gender</p>
<input type="radio" name="male" id="male" value="1">Male<br>
<input type="radio" name="female" id="female" value="0">Female<br>
<input type="submit" name="btnSubmitGender" id="btnSubmitGender">
</form>
</div>
</center>
</body>
</html>
