<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
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
<p>Was this a relay?<br>If Yes, the time and distance will<br>be for the whole team<p><br>
<input type="radio" name="relay" value="1" checked>Yes<br>
<input type="radio" name="relay" value="0">No<br><br><br>
<input type="submit" value = "next" name="btnSubmitRelay" id="btnSubmitRelay">
</form>
</div>
</center>
</body>
</html>

