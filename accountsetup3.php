<!DOCTYPE html>
<html>
<link rel="stylesheet" href="prelogin.css" title="external file sheet">
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
<div class="namediv">
<form id="infoform" name="infoform" method="post" action="getuserinfo.php">
<h2>You are a...</h2>
<input type="radio" name="preference" value="Sprinter">Sprinter (100-400m)<br>
<input type="radio" name="preference" value="mid">Middle Distance Runner (800-1500m)<br>
<input type="radio" name="preference" value="midlong">Distance Runner (3200m-Marathon)<br>
<input type="radio" name="preference" value="long">Ultra Marathoner (Marathon+)<br>
<input type="submit" name="btnSubmitPref" id="btnSubmitPref" value="next">
</form>
</div>
</center>
</body>
</html>
