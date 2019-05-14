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
<title>Group Setup</title>
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
<div class="biodiv">
    <?php
    if ($error == 1)
        echo "<strong>All Fields Required</strong>";
    ?>
<form id="infoform" name="infoform" method="post" action="getgroupinfo.php">
<p>Write a short description of this group</p><br>
<textarea type="biography" name="txtBio" id="txtBio" class="inputtext" rows="6" cols="15"></textarea><br>
<input type="submit" name="btnSubmitBio" id="btnSubmitBio">
</form>
</div>
</center>
</body>
</html>
