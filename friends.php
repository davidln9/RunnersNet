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
    
    function mysort($a, $b) {
        
        if ($a == $b)
            return 0;
        return strcasecmp($a['firstname'],$b['firstname']);
    }
    //echo "<div class='messagebody'>";
    $findex = 0;
    $name = array();
    $friend = array();
    if ($call = mysqli_query($db, "CALL GetFriends('$cid')")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            if ($row['person1'] == $cid) {
                $friend[$findex] = $row['person2'];
            } else {
                $friend[$findex] = $row['person1'];
            }
            $findex++;
            // echo $findex;
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getfriends: ".mysqli_error($db);
    }
    echo "<div class='friendresults'>";
    
    // echo "hi";
    //echo "feed";
    for ($f = 0; $f < $findex; $f++) {
        $thisfriend = $friend[$f];
        if ($call = mysqli_query($db, "CALL getBasicInfo('$thisfriend')")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                //echo "name";
                $name[$f]['firstname'] = trim($row['firstname']);
                $name[$f]['lastname'] = trim($row['lastname']);
                $name[$f]['pic'] = trim($row['img_filepath']);
                $name[$f]['id'] = $row['cryptID'];
                
                // echo "in";
            }
            $call->free();
            $db->next_result();
        } else {
            echo $thisfriend." + ".mysqli_error($db);
        }
    }
    // include_once "alphasort.php";
    //$sort = alphasort::getOrder($name, $findex);
    // $sortobj = new alphasort();
    // $sort = array_slice($name, 0,2)
    $sort = $name;
    usort($sort, "mysort");
    //echo count($sort);
    // $sort = alphasort::getOrder($name, $findex);
    // $sort = $sortobj->merge_sort($name);
    // echo "hi";
    //$sort = $name;
    //echo $findex;
    
    for ($i = 0; $i < $findex; $i++) {
        
        $fid = $sort[$i]['id'];
        
        echo "<div class='messagefriends'>";
        echo "<div class='displaypic'>";
        echo profilepic::getPic(30, $sort[$i]['pic']);
        echo "</div>"; //closes picresults
        echo "<div class='messagename'>";
        $theID = $sort[$i]['id'];
        echo "<a href='viewprofile.php?id=$theID'>".$sort[$i]['firstname']." ".$sort[$i]['lastname']."</a>";
        echo "<button id='btnOptions' onclick='goToOptions($fid)'>Options</button>";
        echo "</div>"; //closes nameresults
        echo "</div>"; //closes messagefriends
        
    }
    echo "</div>"; //close resultfeed
    ?>

    <script>
        function goToOptions(friend) {
            window.location.href="accountoptions.php?type=1&id=" + friend;
        }
    </script> 
    </body>
</html>

