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
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
    echo "<div class='distancediv'>";
    $error = isset($_GET['err']) ? $_GET['err'] : 10;
    if ($error == 0) {
        echo "<p><strong>Shoes Added</strong></p>";
    } elseif ($error == 1) {
        echo "<p><strong>All Fields Required</strong></p>";
    }
?>
<form id="typeform" name="typeform" method="post" action="insertshoes.php">
<p>Brand:</p><br>
<input type="inputtext" name="brand" id="brand"><br>
<p>Name (do not reuse if you have<br>another pair):</p><br>
<input type="inputtext" name="name" id="name"><br>
<p>Year:</p><br>
<input type="inputtext" id="year" name="year"><br>
<input type="submit" value="submit" name="btnSubmitShoes" id="btnSubmitShoes">
</form>
</div>
</center>
</body>
</html>
     
