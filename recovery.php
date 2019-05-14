<!DOCTYPE html>
<html>
<header>
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
    <link rel="stylesheet" media="screen and (min-width: 550px)" href="css/indexstyles.css">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/smallindexstyles.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Recover Password</title>

<div class="titlediv">
</div>
<div class='forgot'></div>
<?php
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
    
</header>
<body>
<center>
<div class='bodydiv'>
<div class='regposts'>
<br>
<?php
if ($error == 90) {
    echo "<p>Your password reset link has been sent</p>";
} elseif ($error == 4) {
    echo "<p><strong>Email not found</strong></p>";
} else {
    ?>
<form id='recoverform' method='post' action='accountrecovery.php'>
<p>Enter your email address</p>
<input type="email" name="recoveremail" id="recoveremail"><br>
<input type="submit" name="btnSubmit" id="btnSubmit">
</form>
<?php
}
?>
</div>
</div>
</center>
</body>
</html>
