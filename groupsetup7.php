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
    $error = isset($_GET['error']) ? $_GET['error'] : null;
    ?>
</div>
</header>
<body>
<center>
<div class="biodiv">
    <p><strong>Upload a Profile Picture</strong></p><br>
    <div class="PreviewPicture" id='image'></div>
<form id="infoform" name="infoform" method="post" action="upload.php" enctype="multipart/form-data">
<input id="FileUpload" type="file" name="ImageUpload">
<input type="submit" value="Upload Image" name="groupProfilePic" id="groupProfilePic">
</form>
</div>
</center>
<script>
    document.getElementById("FileUpload").onchange = function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("image").style.backgroundImage = "url(" + e.target.result + ")";
            
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };
    </script>
</body>
</html>
