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
<title>Account Setup</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    $error = isset($_GET['error']) ? $_GET['error'] : null;
    ?>
</div>
</header>
<body>
<center>
<form id="typeform" name="typeform" method="post" action="getspeedentry.php">
<div class="distancediv">
    <?php
    if ($error == 1) {
        echo "<p><strong><font-color = 'red'>All Fields Required</font></strong></p>";
    }
    ?>
    <p>Describe what you did<br>(Ex: 12x400m, 800m repeats, etc.)</p>
<textarea name="description" id="description"></textarea><br><br>
<input type="submit" name="btnSubmitDescription" id="btnSubmitDescription">
</form>
</div>
</center>
</body>
</html>

