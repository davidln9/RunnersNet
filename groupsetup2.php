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
<div class="namediv"><p>What type of group is this?</p>
<input type='radio' name='grouptype' value='1' checked>High School Track Team<br>
<input type='radio' name='grouptype' value='2'>High School Cross Country Team<br>
<input type='radio' name='grouptype' value='3'>College Track Team<br>
<input type='radio' name='grouptype' value='4'>College Cross Country Team<br>
<input type='radio' name='grouptype' value='5'>Running Group<br>
<input type='radio' name='grouptype' value='6'>Software Development Team<br>
<input type="submit" name="btnSubmitType" id="btnSubmitType">
</form>
</div>
</center>
</body>
    </html>
