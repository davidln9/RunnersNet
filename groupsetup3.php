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
<form id="infoform" name="infoform" method="post" action="getgroupinfo.php">
<div class="namediv"><p>How may someone join this group?</p>
<input type='radio' name='joinmethod' value='1' checked>Anyone Can Join (no invitation)<br>
<input type='radio' name='joinmethod' value='2'>Invitation Only (Any member can invite someone)<br>
<input type='radio' name='joinmethod' value='3'>Restricted (Only Moderators or the Administrator can invite)<br>
<input type="submit" name="btnSubmitMethod" id="btnSubmitMethod">
</form>
</div>
</center>
</body>
</html>
