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
    <p>Write a short journal about the workout<p><br>
    <textarea id="txtJournal" name="txtJournal" rows="7" cols="18"></textarea><br>
    <input type="submit" name="btnSubmitJournal" id="btnSubmitJournal">
</form>
</div>
</center>
</body>
</html>

