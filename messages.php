<?php
    include 'sessioncheck.php';
    include_once "profilepic.php";
    include "elapsedtime.php";
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
<title>Messages</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    ?>
</div>
</header>
<body>
    
    <?php
    
    function mysort($a, $b) {
        
        if ($a == $b)
            return 0;
        elseif ($a['unread'] != 0 || $b['unread'] != 0) 
            return $a['unread'] < $b['unread'];
        return strcasecmp($a['firstname'],$b['firstname']);
    }
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) < strtotime($b['date']);
    }
    
    $messages = array();
    $index = 0;
    if ($call = mysqli_query($db, "CALL GetMessages('$cid')")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $messages[$index]['sender'] = $row['sender'];
            $messages[$index]['id'] = $row['id'];
            $messages[$index]['date'] = $row['date'];
            $messages[$index]['text'] = $row['text'];
            $messages[$index]['img'] = $row['img_filepath'];
            $messages[$index]['read'] = $row['read'];
            $messages[$index]['time_elapse'] = elapsedtime::getElapsedTime($row['date']);
            $index++;
        }
         $call->free();
         $db->next_result();
    } else {
        echo "getmessages: ".mysqli_error($db);
    }
    usort($messages, "datesort");
    
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
        $thisfriendunread = 0;
        
        //count how many unread messages are from this friend
        for ($q = 0; $q < $index; $q++)
            if ($messages[$q]['read'] == 0 && $messages[$q]['sender'] == $thisfriend)
                $thisfriendunread++;
        
        if ($call = mysqli_query($db, "CALL getBasicInfo('$thisfriend')")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                //echo "name";
                $name[$f]['firstname'] = trim($row['firstname']);
                $name[$f]['lastname'] = trim($row['lastname']);
                $name[$f]['pic'] = trim($row['img_filepath']);
                $name[$f]['id'] = $row['cryptID'];
                $name[$f]['unread'] = $thisfriendunread;
                // echo "in";
            }
            $call->free();
            $db->next_result();
        } else {
            echo $thisfriend." + ".mysqli_error($db);
        }
    }
    
    //$name = $name;
    usort($name, "mysort");
    
    for ($i = 0; $i < $findex; $i++) {
        
        echo "<div class='messagefriends'>";
        echo "<div class='displaypic'>";
        echo profilepic::getPic(30, $name[$i]['pic']);
        echo "</div>"; //closes picresults
        echo "<div class='messagename'>";
        $theID = $name[$i]['id'];
        $unreadtf = $name[$i]['unread'];
        if ($unreadtf == 0)
            echo "<a href='sendmessage.php?id=$theID'>".$name[$i]['firstname']." ".$name[$i]['lastname']."</a>";
        else
            echo "<a href='sendmessage.php?id=$theID'>".$name[$i]['firstname']." ".$name[$i]['lastname']."(".$unreadtf.")</a>";
        echo "</div>"; //closes nameresults
        echo "</div>"; //closes messagefriends
        
    }
    echo "</div>"; //close resultfeed
    ?>
    
    <?php
    echo "<div class='messagestream'>";
    
    for ($f = 0; $f < $index; $f++) {
        
        $timeElapsed = $messages[$f]['time_elapse'];
        
        $sender = $messages[$f]['sender'];
        // echo $sender;
        // $firstname;
//         $pic;
//         $lastname;
        //if ($messages[$f]['read'] != 2) {
            if ($call = mysqli_query($db, "CALL getBasicInfo('$sender')")) {
                // echo $sender;
                while ($row = mysqli_fetch_array($call)) {
                    // echo "here";
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $pic = $row['img_filepath'];
                }
                $call->free();
                $db->next_result();
                
            } else {
                echo mysqli_error($db);
            }
            //}
            //$firstname="Joe";
        $messageStatus = $messages[$f]['read'];
        
        // echo $messageStatus;
        if ($messageStatus == 0) {
            $messageID = $messages[$f]['id'];
            echo "<div class='message'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='unreadmessages'>";
            echo "<div class='prevcommentrow'>";
            echo "<div class='commenterpic'";
            echo "<div class='postpic'>";
            echo profilepic::getPic(50, $pic);
            echo "</div>"; //closes postpic
            echo "<div class='commentername'>";
            echo "<p><a href='sendmessage.php?id=$sender'>".$firstname." ".$lastname."</a><br>".$timeElapsed;
            echo "</div>"; //close regposthead
            echo "</div>";
            echo "<div class='commenttext'>";
            echo $messages[$f]['text'];
            echo "</div>";
            echo "</div>";
            echo "</div>"; //closes floater
            echo "</div>"; //closes message
            
        } else if ($messageStatus == 1) {
            echo "<div class='message'>";  // MESSAGE
            echo "<div class='regpostfloater'>"; //FLOATER
            echo "<div class='readmessages'>"; //READMESSAGES
            echo "<div class='prevcommentrow'>";
            echo "<div class='commenterpic'"; //COMMENTERPIC
            echo "<div class='postpic'>"; //POSTPIC
            echo profilepic::getPic(50, $pic);
            echo "</div>"; //closes postpic
            //echo "</div>"; //closes commenterpic
            
            echo "<div class='commentername'>";
            echo "<p><a href='sendmessage.php?id=$sender'>".$firstname." ".$lastname."</a><br>".$timeElapsed;
            echo "</div>"; //close postname
            echo "</div>";
            //echo "<div class='prevcommentfloater'>";
            echo "<div class='commenttext'>";
            echo $messages[$f]['text'];
            // echo "</div>"; //closes messagetext
            echo "</div>"; //closes prevcommentfloater
            echo "</div>"; //closes postnmame
            echo "</div>"; //closes floater
            echo "</div>"; //closes message
        }
    } //closes for loop with $index
    echo "</div>"; //closes messagestream
    // echo "</div>"; //closes messagebody
    ?>

</body>
</html>

