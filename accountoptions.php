<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Your Friends</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
    include 'menu.php';
    echo "</div>";
    $type = (isset($_GET['type'])) ? $_GET['type'] : null ;
    $fid = (isset($_GET['id'])) ? $_GET['id'] : null ;
    
    $firstname;
    $lastname;
    $photo;
    if ($call = mysqli_query($db, "CALL getBasicInfo($fid)")) {
        
        while ($row = mysqli_fetch_array($call)) {
            
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $photo = $row['img_filepath'];
        }
        $call->free();
        $db->next_result();
    } else {
        echo "php line 21 ".mysqli_error($db);
    }
    
            echo "<div class='notfriends'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='picresults'>";
            echo profilepic::getPic(50,$photo);
            echo "</div>";
            echo "<div class='namereport'>";
            echo $firstname." ".$lastname."<br>";
            echo "<input type='button' value='Remove Friend' name='btnremove' id='btnremove' onclick='removeFriend($fid)'><br>";
            echo "<input type='button' value='Report' name='btnReport' id='btnReport' onclick='report($fid)'>";

            echo "</div>";
            echo "</div>"; //closes floater
            echo "</div>"; //closes notfriends
            echo "</div>";
    ?>
    <script>
        function removeFriend(userid) {
            var button = document.getElementById("btnremove");
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "friendaction.php?action=" + 1 + "&user=" + userid);
            xmlhttp.send();
            button.id="undoButton";
            button.value="Undo Remove";
            button.onclick= function(){undoRemove(userid);}
        }
        function undoRemove(userid) {
            
            var button = document.getElementById("undoButton");
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "friendaction.php?action=" + 2 + "&user=" + userid);
            xmlhttp.send();
            button.id="btnremove";
            button.value="Remove Friend";
            button.onclick= function(){removeFriend(userid);}
        }
        function report(userid) {
            window.location.href="reportuser.php?id=" + userid;
        }
    </script>
    </body>
</html>

