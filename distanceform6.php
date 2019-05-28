<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
        <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
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
<p>Who did you run with?<p><br>
<input type="inputtext" name="team" id="team">
<input type="submit" name="btnSubmitTeam" id="btnSubmitTeam" autocomplete = "off">
</form>
</div>
</center>
</body>
</html>

