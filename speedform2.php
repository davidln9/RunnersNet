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
<title>Speed Workout</title>
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
    } elseif ($error == 2) {
        echo "<p><strong><font-color = 'red'>Invalid date/time</font></strong></p>";
    }
    ?>
<p>What was the date of this speed workout?<br>(mm/dd/yyyy)</p><br>
<input type="date" name="date" id="date" autocomplete = "off"><br>
<p>What was the time of this speed workout?<br>(hh:mm am/pm)</p><br>
<input type="time" name="time" id="time" autocomplete = "off"><br><br>
<input type="submit" name="btnSubmitDateTime" id="btnSubmitDateTime">
</form>
</div>
</center>
</body>
</html>

