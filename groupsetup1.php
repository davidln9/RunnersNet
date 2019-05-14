<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>	
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
    <?php
    $error = isset($_GET['error']) ? $_GET['error'] : null;
    ?>
<form id="infoform" name="infoform" method="post" action="getgroupinfo.php">
    <div class="namediv">
    <?php
    if ($error == 1) {
        echo "<p><strong>All Fields Required</strong></p>";
    }
    ?>
<p>What is the name of this group?</p><br>
<input type="firstname" class="inputtext" name="name" id="name"><br>
<input type="submit" name="btnSubmitName" id="btnSubmitName">
</form>
</div>
</center>
</body>
    </html>
