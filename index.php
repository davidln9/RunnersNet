<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" media="screen and (min-width: 550px)" href="css/indexstyles.css">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/smallindexstyles.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>The Runners Net | Log in or Sign up</title>
<div class="titlediv">
<meta name="description" content="The Runners Net is a social media website for runners to track their mileage and share their experiences.">
<meta name="keywords" content="social media,running,journal,active lifestyle,fitness,Runners Net,Runners">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
}
?>
<form id="loginform" action="login.php" name="loginform" method="post">
<label for="retemail">Email:</label>
<input type="email" class="inputtext" name="retemail" id = "retemail">
<label for="retpass">Password:</label>
<input type="password" class="inputtext" name="retpass" id="retpass">
<label class="uibutton" id="btnLogin" name="btnLogin"></label>
<input value="log in" type="submit" id="login" name="login">
</form>
</div>
<div class='forgot'><a href='recovery.php'>Forgot?</a></div>

</header>
<body>
    <div class='bodydiv'>
        <div class='regposts' id='regposts'>
<center>
    <?php
        $error = isset($_GET['id']) ? $_GET['id'] : null;
        if ($error == 12) {
            echo "<center><strong><font color='red'>Email Address Already Taken</font></strong></center>";
        } else if ($error == 11) {
            echo "<center><strong><font color = 'red'>Passwords must match</font></strong></center>";
        } else if ($error == 10) {
            echo "<center><strong><font color='red'>All fields required</font></strong></center>";
        } elseif ($error == 99) {
            echo "<center><strong>Password Successfully Reset</strong></center>";
        }
        ?>
<form id="form1" name="form1" method="post" action="getuserinfo.php">
<h1>The Runners Net</h1>
<br>Log In or Create Account<br>
<label for="email">Email:</label>
<br><input type="email" class="inputtext" name="email" id="email" tabindex="1" maxlength="100">
<br><label for="pass">Password:</label>
<br><input type="password" class="inputtext" name="pass" id="pass" tabindex="2" maxlength="100">
<br><label for="cpass">Confirm Password</label>
<br><input type="password" class="inputtext" name="cpass" id="cpass" tabindex="3" maxlength="100">
<br><label for="city">City:</label>
<br><input type="city" class="inputtext" name="city" id="city" tabindex="5">
<br><label for="state">State:</label>
<br><input type="state" class="inputtext" name="state" id="state" tabindex="6">
<br><label for="birthdate">Date Of Birth:</label>
<br><input type="date" class="inputtext" name="birthdate" id="birthdate">
<br><input type="submit" name="btnCreate" id="btnCreate" value="Create Account">
</form>
</div>
</div>
</center>
<div class="infodiv" id='infodiv'>
<p>The Runners Net by Potatoes - Made By Living Potatoes For Living Potatoes - Much Thanks To Our Imaginary Sponsor Spud Air - The Only Airline Made By Living Potatoes For Living Potatoes - Much Thanks To Their Imaginary Sponsor - Yam Industries - The Imaginary Multinational Corporation Ran By Living Potatoes For Living Potatoes</p>
</div>
</body>
</html>
