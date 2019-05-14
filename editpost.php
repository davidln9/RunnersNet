<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Edit Post</title>
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
// $id = isset($_GET['id']) ? $_GET['id'] : null;
$ptype = isset($_GET['type']) ? $_GET['type'] : null;
$pid = isset($_GET['postid']) ? $_GET['postid'] : null;
$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
//echo $id." ".$ptype." ".$pid;
$text;
$pic;
date_default_timezone_set("MST");
if ($ptype == 3) {
    if ($call = mysqli_query($db, "CALL GetPost('$cid','$pid')")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $text = trim($row[4]);
            $pic = trim($row[5]);
        }
        $call->free();
        $db->next_result();
    } else {
        echo mysqli_error($db);
    }
    echo "<div class='editpostcontent'>";
        echo "<div class='editposttext'>";
            echo "<form method='post' action='postchanges.php'>";
            echo "<textarea rows='5' cols = '30' name = 'txttext' id='txttext'>$text</textarea><br>";
            echo "<input type='hidden' value='$pid' name='postID' id='postID'>";
            echo "<input type='hidden' value='$ptype' name='posttype' id='posttype'>";
            echo "<input type='submit' value='save' id='btnsavetext' name = 'btnsavetext'>";
            echo "</form>";
        echo "</div>";
        
        if ($pic != null) {
        ?>
        <div class='editpostpic'>
            <div class='picoptions'>
                <div class='displaypic'>
                    <?php echo profilepic::getPic(200, $pic)?>
                </div>
                <form method='post' action='postchanges.php' enctype='multipart/form-data'>
                    <?php echo "<input type='hidden' name='postID' id='postID' value='$pid'>"; ?>
                    <?php echo "<input type='hidden' name='posttype' id='posttype' value='$ptype'>"; ?>
                    <input type="file" aria-label="Picture/Video" name="fileToUpload" id="fileToUpload"><br>
                    <input type='submit' value='Save' name='btnsavepic' id='btnsavepic'>
                </form>
            </div>
        </div>
        <?php
    }
} elseif ($ptype == 0) {
    if ($call = mysqli_query($db, "CALL GETDISTANCEENTRY($pid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $datetime = $row['date'];
            $public = $row['public'];
            $location = $row['location'];
            $team = $row['team'];
            $intensity = $row['intensity'];
            $journal = $row['journal'];
            $runtime = $row['runtime'];
            $pace = $row['pace'];
            $distance = $row['distance'];
        }
        $call->free();
        $db->next_result();
        
        try {
            $datetime = new DateTime($datetime);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $time = $datetime->format("g:i a");
        $date = $datetime->format("m/d/Y");
    } else {
        echo "<p><strong>Error</strong></p>";
    }
    echo "<div class='editpostcontent'>";
    echo "<div class='editposttext'>";
    if ($msg == 1)
        echo "<p><strong>All Fields Required</strong></p>";
    elseif ($msg == 2)
        echo "<p><strong>System Error. Try Again Later</strong></p>";
    elseif ($msg == 3)
        echo "<p>Distance Entry Updated</p>";
    
    echo "<form method='post' action='postchanges.php'>";
    echo "<label for='public'>Who can view?</label><br>";
    echo "<select name='public' id='public'>";
    
    if ($public == 1)
        echo "<option value='1' selected='selected'>Friends</option>";
    else
        echo "<option value='1'>Friends</option>";
    if ($public == 0)
        echo "<option value='0' selected='selected'>Only Me</option>";
    else
        echo "<option value='0'>Only Me</option>";
    echo "</select><br>";
    echo "<label for='date'>Date: (mm/dd/yyyy)</label><br>";
    echo "<input type='date' name='date' id='date' value='$date'><br>";
    echo "<label for='time'>Time: (hh:mm am/pm)</label><br>";
    echo "<input type='time' name='time' id='time' value='$time'><br>";
    echo "<label for='location'>Location:</label><br>";  
    echo "<input type='text' name='location' id='location' value='$location'><br>";
    echo "<label for='team'>With:</label><br>";
    echo "<input type='text' name='team' id='team' value='$team'><br>";
    echo "<label for='intensity'>Intensity:</label><br>";
    echo "<select name='intensity' id='intensity'>";
    if ($intensity == 1)
        echo "<option value='1' selected='selected'>Low</option>";
    else
        echo "<option value='1'>Low</option>";
    if ($intensity == 2)
        echo "<option value='2' selected='selected'>Between Low and Medium</option>";
    else
        echo "<option value='2'>Between Low and Medium</option>";
    if ($intensity == 3)
        echo "<option value='3' selected='selected'>Medium</option>";
    else
        echo "<option value='3'>Medium</option>";
    if ($intensity == 4)
        echo "<option value='4' selected='selected'>Between Medium and High</option>";
    else
        echo "<option value='4'>Between Medium and High</option>";
    if ($intensity == 5)
        echo "<option value='5' selected='selected'>High</option>";
    else
        echo "<option value='5'>High</option>";
    echo "</select><br>";
    
    echo "<label for='distance'>Distance:</label><br>";
    echo "<input type='text' name='distance' id='distance' value='$distance'><br>";
    echo "<label for='runtime'>Time: (hh:mm:ss)</label><br>";
    echo "<input type='text' name='runtime' id='runtime' value='$runtime'><br>";
    echo "<label for='journal'>Journal:</label><br>";
    echo "<textarea name='journal' id='journal'>$journal</textarea><br>";
    echo "<input type='hidden' name='ptype' id='ptype' value='$ptype'>";
    echo "<input type='hidden' name='pid' id='pid' value='$pid'>";
    echo "<input type='submit' name='btnUpdateDistance' id='btnUpdateDistance' value='Save'>";
    echo "</form></div></div>";
} elseif ($ptype == 1) {
    if ($call = mysqli_query($db, "CALL GETSPEEDENTRY($pid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $location = $row['location']; //
            $datetime = $row['date']; //
            $description = $row['description']; //
            $team = $row['team'];//
            $journal = $row['journal'];//
            $public = $row['privacy'];//
            $warmup = $row['warmup'];// 
            $cooldown = $row['cooldown']; //
            $workout = $row['workout']; //
        }
        $call->free();
        $db->next_result();
        
        try {
            $thedate = new DateTime($datetime);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        $date = $thedate->format("m/d/Y");
        $time = $thedate->format("g:i a");
    } else {
        echo "<p><strong>Error</strong></p>";
    }
    
    echo "<div class='editpostcontent'>";
    echo "<div class='editposttext'>";
    if ($msg == 1)
        echo "<p><strong>All Fields Required</strong></p>";
    elseif ($msg == 2)
        echo "<p><strong>System Error. Try Again Later</strong></p>";
    elseif ($msg == 3)
        echo "<p>Speed Entry Updated</p>";
    
    echo "<form method='post' action='postchanges.php'>";
    echo "<label for='public'>Who can view?</label><br>";
    echo "<select name='public' id='public'>";
    
    if ($public == 1)
        echo "<option value='1' selected='selected'>Friends</option>";
    else
        echo "<option value='1'>Friends</option>";
    if ($public == 0)
        echo "<option value='0' selected='selected'>Only Me</option>";
    else
        echo "<option value='0'>Only Me</option>";
    echo "</select><br>";
    // echo $date." ".$time;
    echo "<label for='date'>Date: (mm/dd/yyyy)</label><br>";
    echo "<input type='text' name='date' id='date' value='$date'><br>";
    echo "<label for='time'>Time: (hh:mm am/pm)</label><br>";
    echo "<input type='text' name='time' id='time' value='$time'><br>";
    echo "<label for='location'>Location:</label><br>";  
    echo "<input type='text' name='location' id='location' value='$location'><br>";
    echo "<label for='team'>With:</label><br>";
    echo "<input type='text' name='team' id='team' value='$team'><br>";
    echo "<label for='warmup'>Warmup Distance:</label><br>";
    echo "<input type='text' name='warmup' id='warmup' value='$warmup'><br>";
    echo "<label for='workout'>Workout Distance:</label><br>";
    echo "<input type='text' name='workout' id='workout' value='$workout'><br>";
    echo "<label for='cooldown'>Cooldown Distance:</label><br>";
    echo "<input type='text' name='cooldown' id='cooldown' value='$cooldown'><br>";
    echo "<label for='description'>Description:</label><br>";
    echo "<textarea name='description' id='description'>$description</textarea><br>";
    echo "<label for='journal'>Journal:</label><br>";
    echo "<textarea name='journal' id='journal'>$journal</textarea><br>";
    echo "<input type='hidden' name='postid' id='postid' value='$pid'>";
    echo "<input type='submit' name='btnUpdateSpeed' id='btnUpdateSpeed' value='Save'>";
    echo "</form></div></div>";
    
}
    ?>
</div>
</center>
</body>
</html>
