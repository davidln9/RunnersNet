<?php
    include 'sessioncheck.php';
    ?>
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
<title>Race Entry</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    ?>
</div>
</header>
<body>
<center>
<form id="typeform" name="typeform" method="post" action="getraceentry.php">
<div class="distancediv">
<p>Time of Race:<p><br>
<input type="inputtext" name="time" id="time">
<input type="submit" value="next" name="btnSubmitTime" id="btnSubmitTime">
</form>
</div>
</center>
</body>
</html>

