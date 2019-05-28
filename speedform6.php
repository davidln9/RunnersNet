<?php
    include 'sessioncheck.php';
    ?>
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
    <p>How long was the warmup?</p>
<input type="text" name="warmup" id="warmup"><br><br>
<p>How long was the workout?</p>
<input type="text" name="workout" id="workout"><br><br>
<p>How long was the cool down?</p>
<input type="text" name="cooldown" id="cooldown"><br><br>
<input type="submit" name="btnSubmitDist" id="btnSubmitDist">
</form>
</div>
</center>
</body>
</html>

