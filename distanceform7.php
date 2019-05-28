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
<p>How intense would you describe it?<p><br>
<select name="optintensity">
    <option value="low">Low</option>
    <option value="lowmed">Between Low and Medium</option>
    <option value="medium">Medium</option>
    <option value="medhigh">Between Medium and High</option>
    <option value="high">High</option>
</select>
<input type="submit" name="btnSubmitIntensity" id="btnSubmitIntensity">
</form>
</div>
</center>
</body>
</html>

