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
    ?>
</div>
</header>
<body>
<center>
<form id="typeform" name="typeform" method="post" action="getdistanceentry.php">
<div class="distancediv">
<p>What was the date of this run?</p><br>
<input type="date" name="date" id="date" autocomplete = "off"><br>
<p>What was the time of this run?</p><br>
<input type="time" name="time" id="time" autocomplete = "off"><br><br>
<input type="submit" name="btnSubmitDateTime" id="btnSubmitDateTime">
</form>
</div>
</center>
</body>
</html>
