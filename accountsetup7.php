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
<?php
    echo "<a href='#' class='headname'>".$uname."</a>";
?>
</div>
</header>
<body>
<center>
<div class="distancediv">
<form id="infoform" name="infoform" method="post" action="getuserinfo.php">
<p>What Pair of Shoes do you normally run in?<br>(You can add more later)</p>
<input type="text" name="make" id="make" placeholder="Brand"></input><br>
<input type="text" name="name" id="name" placeholder="name"></input><br>
<input type="text" name="year" id="year" placeholder="year"></input><br>
<input type="submit" name="btnSubmitShoe" id="btnSubmitShoe">
</form>
</div>
</center>
</body>
</html>
