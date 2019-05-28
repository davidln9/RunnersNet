<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Log Distance Run</title>
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
<p>Do you want to share this<br>with your friends?<p><br>
<input type="radio" name="pub" value="1" checked>Yes<br>
<input type="radio" name="pub" value="0">No<br><br><br>
<input type="submit" name="btnSubmitPub" id="btnSubmitPub">
</form>
</div>
</center>
</body>
</html>

