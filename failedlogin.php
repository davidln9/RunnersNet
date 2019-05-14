<!DOCTYPE html>
<html>
<link rel="stylesheet" href="prelogin.css" title="external file sheet">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<head>
    <title>Failed Login</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>
<body>
<center>
<p3>Invalid User Name or Password</p3>
<form id="loginform" action="login.php" name="loginform" method="post">
<table>
<thead>
<tr>
<td><label for="retemail">Email:</label></td>
<td><label for="retpass">Password:</label></td>
</tr>
</thead>
<tbody>
<tr>
<td><input type="email" class="inputtext" name="retemail" id = "retemail"></td>
<td><input type="password" class="inputtext" name="retpass" id="retpass"></td>
<td><label class="uibutton" id="btnLogin" name="btnLogin">
<input value="log in" type="submit" id="login" name="login"></label>
</td>
</tr>
</tbody>
<p>New user? <a href="index.php">Sign Up</a></p>
</form>
</body>
</center>
</html>
