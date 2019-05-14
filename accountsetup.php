<!DOCTYPE html>
<html>
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<link rel="stylesheet" href="prelogin.css" title="external file sheet">
<header>
<title>Account Setup</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
</div>
</header>
<body>
<center>
<form id="infoform" name="infoform" method="post" action="getuserinfo.php">
<div class="namediv">
<label for="firstname">First Name</label><br>
<input type="firstname" class="inputtext" name="firstname" id="firstname"><br>
<label for="lastname">Last Name</label><br>
<input type="lastname" class="inputtext" name="lastname" id="lastname"><br>
<input type="submit" name="btnSubmitName" id="btnSubmitName">
</form>
</div>
</center>
</body>
    </html>
