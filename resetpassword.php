<!DOCTYPE html>
<html>
<header>
<?php
require 'secure.php';
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
<title>Reset Password</title>

<div class="titlediv">
</div>
<div class='forgot'></div>
<?php
$error = isset($_GET['error']) ? $_GET['error'] : null;
$user1 = isset($_GET['user']) ? $_GET['user'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$realid = 0;
$legit = false;
$num = 0;
$db = mysqli_connect($server,$user,$password,$database) or die("no connection");
if ($call = mysqli_query($db, "CALL GETRECOVERY('$user1', $id)")) {
    while ($row = mysqli_fetch_array($call)) {
        $realid = $row['resetID'];
        $expdate = $row['expiredate'];
        $num++;
    }
    $call->free();
    $db->next_result();
} else {
    echo mysqli_error($db);
}

?>
</header>
<body>
<center>
<div class='bodydiv'>
<div class='regposts'>
<?php
date_default_timezone_set("MST");
if ($num == 1) {
    if (strtotime($expdate) > strtotime(date("m/d/Y g:i a"))) {
        $legit = true;
    } else {
        echo "<p><strong>Expired Link</strong></p>";
    }
} else {
    echo "<p><strong>Invalid Link</strong></p>";
}
if ($error == 1) {
    echo "<p><strong>Passwords do not match</strong></p>";
} elseif ($error == 2) {
    echo "<p><strong>Password fields are empty</strong></p>";
}
?>
    

<br>
<?php
if ($legit) {
    ?>
<form id='recoverform' method='post' action='accountrecovery.php'>
<p>Enter New Password</p>
<input type="password" name="pass1" id="pass1"><br>
<p>Re-enter New Password</p>
<input type="password" name="pass2" id="pass2">
<input type="hidden" name="email" id="email" value="<?php echo $user1; ?>"><br>
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
<input type="submit" name="btnSubmitPass" id="btnSubmitPass"><br>
</form>
<?php
}
?>
</div>
</div>
</center>
</body>
</html>
