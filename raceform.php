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
<p>Date of Race:<br>mm/dd/yyyy<p><br>
<input type="inputtext" name="date" id="date">
<input type="submit" value="next" name="btnSubmitDate" id="btnSubmitDate">
</form>
</div>
</center>
</body>
</html>

