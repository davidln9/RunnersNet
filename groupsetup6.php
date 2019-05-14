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
<p>What kind of moderation do you want for page posts?</p><br>
<input type='radio' name='rdbMod' value='0' checked>No Moderation<br>
<input type='radio' name='rdbMod' value='1'>All Posts Moderated<br>
<input type='radio' name='rdbMod' value='2'>Only Moderate New Members<br>
<input type="submit" name="btnSubmitMod" id="btnSubmitMod">
</form>
</div>
</center>
</body>
</html>
