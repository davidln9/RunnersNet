<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    //include 'mileage.php';
    ?>
<!DOCTYPE html>
<html>

<header>
    
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
<link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<title>View Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<div class="titlediv">
<?php
    $mileage = 0;
    $weekmil = 0;
    $monthmil=0;
    $yearmil=0;
    $index = 0;
    
    $store = array();
    $basic = array();
    if ($call = mysqli_query($db, "CALL getBasicInfo($cid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $lim = mysqli_num_fields($call);
            for ($i=0;$i<$lim;$i++) {
                $basic[$i] = $row[$i];
            }
        }
        $call->free();
        $db->next_result();
    }
    $notif = 0;
    $reqind = 0;
    
    include "feedloader.php";
    $action = new FeedLoader();
    
    $diststmt = $db->prepare("CALL GETDISTANCE(?)");
    $racestmt = $db->prepare("CALL GETRACES(?)");
    $poststmt = $db->prepare("CALL GETUSERPOSTS(?)");
    $pgpoststmt = $db->prepare("CALL GETPAGEPOSTS(?)");
    $repoststmt = $db->prepare("CALL GETREPOSTS(?)");
    $speedstmt = $db->prepare("CALL GETSPEED(?)");
    $limstmt = $db->prepare("CALL GETLIMITS(?)");
    $limstmt->bind_param("i", $cid);
    $limstmt->execute();
    $result = $limstmt->get_result();
    $hasLimit = false;
    while ($row = $result->fetch_assoc()) {
        $hasLimit = true;
        $dist10 = $row['distanceLoad'];
        $distLimit = $row['distanceEntries'];
        $speed10 = $row['speedLoad'];
        $speedLimit = $row['speedEntries'];
        $race10 = $row['raceLoad'];
        $raceLimit = $row['raceEntries'];
        $pagePost10 = $row['pagePostLoad'];
        $pagePostLimit = $row['pagePostEntries'];
        $grpPagePost10 = $row['grpPagePostLoad'];
        $grpPagePostLimit = $row['grpPagePostEntries'];
        $post10 = $row['postLoad'];
        $postLimit = $row['postEntries'];
        $grpPost10 = $row['grpPostsLoad'];
        $grpPostLimit = $row['grpPostEntries'];
    }
    $db->next_result();
    if ($hasLimit) {

        if ($post10 == 1) {
            $post10 = true;
        } else {
            $post10 = false;
        }
        if ($dist10 == 1) {
            $dist10 = true;
        } else {
            $dist10 = false;
        }

        if ($speed10 == 1)
            $speed10 = true;
        else
            $speed10 = false;

        if ($race10 == 1)
            $race10 = true;
        else
            $race10 = false;

        if ($pagePost10 == 1)
            $pagePost10 = true;
        else
            $pagePost10 = false;

        if ($grpPagePost10 == 1)
            $grpPagePost10 = true;
        else
            $grpPagePost10 = false;

        if ($grpPost10 == 1)
            $grpPost10 = true;
        else
            $grpPost10 = false;

    }
        
    
     
    //load the user's posts into store
    list($store, $index) = $action->loadFeed($cid, $store, $index, $speedstmt, $diststmt, $racestmt, $poststmt, $pgpoststmt, $repoststmt, $db);
    
    //list($yearmil,$monthmil,$weekmil) = mileage::getmileages($store);
    
    unset($action);
    include 'menu.php';
    // echo "<div class='milesdiv'>";
//     echo "Total Miles<br>This Year: ".$yearmil."&nbsp This Month: ".$monthmil."&nbsp This Week: ".$weekmil;
//     echo "</div>";
    
    
    //echo "</div>";
    ?>
</div>
</header>
<body>
<div class="content">
<div class="profilecol">
<div class="profilepic">
<?php
    echo profilepic::getProfilePic(100);
    ?>
</div>
<div class="biography">
<?php
    echo trim($basic[9]);
    ?>
</div>
<div class="profile_options">
<table>
<tbody>
<tr>
<td>
<a href="editprofile.php?id=1">Edit Profile</a>
</td>
</tr>
<tr>
<td>
<a href="grouppage.php">Groups</a>
</td>
</tr>
<tr>
<td>
<a href="journal.php">Running Journal</a>
</td>
</tr>
<tr>
<td>
<a href="friends.php">Friends</a>
</td>
</tr>
</tbody>
</table>
</div>

</div>
</div>



<div class="createpost">
<div class="menubuttons">
<input type="button" class="redirect" value="Distance Run" id="dist" onclick="goToDist()">
<input type="button" class="redirect" id="speed" value="Speed Workout" onclick="goToSpeed()">
<input type="button" class="redirect" id="race" value="Race" onclick="goToRace()">
</div>
<script>
    function goToSpeed() {
        window.location.href="speedform1.php";
    }
function goToDist() {
    window.location.href="distanceform1.php";
}
function goToRace() {
    window.location.href="raceform.php";
}
</script>
<div class="opentext">
<form id="textform" name="textform" method="post" action="textpost.php" enctype="multipart/form-data">
<textarea id="content" rows="3" cols = "50" name="content" placeholder="Say it here"></textarea>
<div class="postbuttons">
<input type="file" aria-label="Picture/" name="fileToUpload" id="fileToUpload">
<input type="hidden" value="3" name="type" id="type">
<input type="hidden" value='<?php echo $cid; ?>' name="encid" id="encid">
<input type="hidden" value="1" name="page" id="page">
<input type="submit" name="btnSubmitText" id="btnSubmitText" value="Post">
</div>
</form>
</div>
</div>
<script>
    function likePost(id,type,poster,compID) {
        var button = document.getElementById("likeButton" + compID);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "likepost.php?id=" + id + "&type=" + type + "&poster=" + poster);
        xmlhttp.send();
        button.id="unlikeButton"+compID;
        button.innerHTML="liked";
        button.onclick= function(){unlikePost(type,id,poster,compID);}
    }
    function unlikePost(type,id,user,compID) {
        var button = document.getElementById("unlikeButton" + compID);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "unlikepost.php?postID=" + id + "&posttype=" + type + "&user=" + user);
        xmlhttp.send();
        button.innerHTML="like";
        button.id="likeButton"+compID;
        button.onclick=function(){likePost(id,type,user,compID);}
    }
</script>
<div class="profilefeed">
    
<?php
    $time_elapse = array();
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) < strtotime($b['date']);
    }
    
    
    usort($store, "datesort");
    
    // $_SESSION['postID']
    
    
    //  Start "unwrapping" the profile page feed
    include "elapsedtime.php";
    
    // echo $index;
    //for ($i = 0; $i < $index; $i++) {
    $i = 0;
    $basicinfo = $db->prepare("CALL GETBASICINFO(?)");
    $likestmt = $db->prepare("CALL GETLIKES(?,?)");
    $comstmt = $db->prepare("CALL GETCOMMENTS(?,?)");
    $groupstmt = $db->prepare("CALL GETGROUPINFO(?)");
    while ($i < $index) {
 
        $toDisplay = true;       
        $posttype = $store[$i]['type'];
        $postID = $store[$i]['id'];
        $poster = $store[$i]['userID'];
        
        //get the likes for the post
        $like = array(); //ID of the like
        $likeIndex = 0;
        
        $likestmt->bind_param("ii", $posttype, $postID);
        $likestmt->execute();
        $result = $likestmt->get_result();

        
        // echo "here";
        while ($row = $result->fetch_assoc()) {
            //$like[$likeIndex]['id'] = $row['id'];
            $like[$likeIndex]['posterID'] = $row['posterID'];
            $like[$likeIndex]['likerID'] = $row['likerID'];
            $like[$likeIndex]['date'] = $row['date'];

            $likeIndex++;
            // echo "here1";
        }
        $db->next_result();
            
        
        //find out if tihs user has liked the post
        $userLike = false;
        $li = 0;
        
        // echo "here";
        while ($li < $likeIndex && $userLike == false) {
            if ($like[$li]['likerID'] == $cid) {
                $userLike = true;
                // echo "yes";
            }
            $li++;
        }
        
        //echo $posttype."<br>".$postID;
        //$number_comments = 0;
        $cind = 0;
        $comment = array();
        
        $comstmt->bind_param("ii", $posttype, $postID);
        $comstmt->execute();
        $result = $comstmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            //echo "inwhile<br>";
            $comment[$cind]['type'] = $row['type'];
            $comment[$cind]['posttype'] = $row['posttype'];
            $comment[$cind]['postID'] = $row['postID'];
            $comment[$cind]['id'] = $row['commentID'];
            $comment[$cind]['date'] = $row['date'];
            $comment[$cind]['userID'] = $row['userID'];
            $comment[$cind]['text'] = $row['text'];
            $comment[$cind]['img_filepath'] = $row['img_filepath'];
            $cind++;
        }
        $db->next_result();
        //$comm determines if there will be a commentdiv for the post
        $comm = true;
        if ($cind == 0) {
            $comm = false;
        }
        
        for ($ci = 0; $ci < $cind; $ci++) {
            $comment[$ci]['time_elapsed'] = elapsedtime::getElapsedTime($comment[$ci]['date']);
        }
        
   
        $time_elapse[$i] = elapsedtime::getElapsedTime($store[$i]['date']);
        $strinten;
        $relay;
        if (intval($store[$i]['type']) == 3) { //POST results
            
            if ($hasLimit) {
                if ($post10) {
                    if ($postCount < $postLimit) {
                        $postCount++;
                    } else {
                        $toDisplay = false;
                    }
                } else {
                    $toDisplay = false;
                }
            }
            if ($toDisplay) {
            echo "<div class='regposts'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='regposthead'>";
            echo "<div class='postpic'>";
            echo profilepic::getProfilePic(50);
            echo "</div>"; //closes postpic
            echo "<div class='postname'>";
            echo "<p><a href='profilepage.php'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i]."</p>";
            if ($store[$i]['userID'] == $cid) {
                //enable user to edit post
                echo "</div>"; //closes postname
                echo "<div class='editpost'>";
                $postid = $store[$i]['id'];
                $query = array('id' => $cid, 'type' => 3, 'postid' => $postid);
                $query = http_build_query($query);
                echo "<a href='editpost.php?$query'>Edit</a>";
                echo "</div>"; //closes editpost
            } else {
                echo "</div>"; //closes postname
            }
            //echo "</div>"; //closes postname
            echo "</div>"; //closes posthead
            echo "</div>"; //floater
            echo "<div class='regpostfloater'>";
            echo "<div class='posttext'>";
            echo "<p>".$store[$i]['text']."</p>";
            echo "</div>"; //closes posttext
            echo "</div>"; //closes floater
            //echo "</div>"; //closes regposts
            if ($store[$i]['img'] != NULL) {
                echo "<div class='regpostfloater'>";
                echo "<div class='regpostpic'>";
                echo profilepic::getPic(460, $store[$i]['img']);
                ?>
</div> <!--closes postpic-->
</div> <!--closes floater-->

<?php
}
if ($userLike == true) {
    
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
    //$query = http_build_query($query);
    //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
    echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
    
} else {
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
//     //$query = http_build_query($query);
    //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
    echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
}
    if ($comm == true) {
        echo "<div class='regpostfloater'>";
        echo "<div class = 'prevcomments'>";
        echo "<div class = 'prevcommentsdiv'>";
        //echo $cind;
        for ($r = 0; $r < $cind; $r++) {
            $commenter_id = $comment[$r]['userID'];
            
            
            if ($comment[$r]['type'] == 5) {
                // echo "hi";
                $basicinfo->bind_param("i", $commenter_id);
                $basicinfo->execute();
                $result = $basicinfo->get_result();

                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['firstname'] = $row['firstname'];
                    $comment[$r]['lastname'] = $row['lastname'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
            } elseif ($comment[$r]['type'] == 10) {
                
                $groupstmt->bind_param("i", $commenter_id);
                $groupstmt->execute();
                $result = $groupstmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['name'] = $row['name'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
                
            }
            $db->next_result();
            echo "<div class='prevcommentfloater'>";
            echo "<div class = 'prevcommenthead'>";
            echo "<div class = 'prevcommentrow'>";
            echo "<div class = 'commenterpic'>";
            echo profilepic::getPic(31, $comment[$r]['img']);
            echo "</div>";  //closes commenterpic
            echo "<div class = 'commentername'>";
            if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                
            } elseif ($comment[$r]['type'] == 10) {
                //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            } else {
                echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            }
            echo "</div>"; //closes commentername
            echo "</div>"; //closes prevcommentrow
            echo "</div>"; //closes commenthead
            echo "</div>"; //closes floater
            echo "<div class='prevcommentfloater'>";
            //echo "</div>";
            echo "<div class = 'commenttext'>";
            echo "<p>".$comment[$r]['text']."</p>";
            echo "</div>";
            echo "</div>";
            
        } //closes for loop
        echo "</div>"; //closes div 'prevcomments'
        echo "</div>"; //closes div 'regpost'
        
        echo "</div>"; //closes floater
    }
    ?>
    <div class = 'regpostfloater'>
    <div class = 'commentdiv'>
    <div class = 'comment'>
    <div class = 'commentpic'>
    <?php
        echo profilepic::getProfilePic(40);
        ?>
    </div> <!-- closes div commentpic-->
    <form method='post' action='submitcomment.php' name='commentform' id='commentform'>
    <div class='insertcomment'>
    <input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30' autocomplete="off">
    </div> <!-- close div insertcomment -->
    <input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    <input type='hidden' value="<?php echo $cid; ?>" name="commenter" id="commenter">
    <input type='hidden' value="1" name="page" id="page">
    </form>
    </div> <!-- close div comment -->
    </div> <!-- closes commentdiv-->
    </div> <!-- closes floater -->
<?php
    echo "</div>";
    } 
    } elseif ($store[$i]['type'] == 6 && $store[$i]['userID'] == null) { //video formatting
        
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getProfilePic(50);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='profilepage.php'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i]."</p>";
        echo "</div>"; //closes postname
        echo "</div>"; //closes postpic
        echo "</div>"; //closes head
        echo "<div class='regpostfloater'>";
        echo "<div class = 'posttext'>";
        echo $store[$i]['text'];
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        //echo $store[$i]['img'];
        echo "<div class='regpostfloater'>";
        echo "<div class='videodiv'>";
        echo "<video width = '460' height='300' preload='auto' controls>";
        ?>
<source src="<?php echo $store[$i]['img']; ?>" type='video/mp4'>

<!--//echo "<source src='uploads/1501835232.MOV' type='video/mp4'>"; -->
</video>
</div> <!-- closes videodiv -->
</div> <!-- closes floater -->

<?php
if ($userLike == true) {
    
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
    //$query = http_build_query($query);
    //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
    echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
    
} else {
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
//     //$query = http_build_query($query);
    //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
    echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
}
    if ($comm == true) {
        echo "<div class='regpostfloater'>";
        echo "<div class = 'prevcomments'>";
        
        echo "<div class = 'prevcommentsdiv'>";
        //echo $cind;
        
        for ($r = 0; $r < $cind; $r++) {
            $commenter_id = $comment[$r]['userID'];
            //echo "loop";
            if ($comment[$r]['type'] == 5) {
                // echo "hi";
                $basicinfo->bind_param("i", $commenter_id);
                $basicinfo->execute();
                $result = $basicinfo->get_result();

                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['firstname'] = $row['firstname'];
                    $comment[$r]['lastname'] = $row['lastname'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
            } elseif ($comment[$r]['type'] == 10) {
                
                $groupstmt->bind_param("i", $commenter_id);
                $groupstmt->execute();
                $result = $groupstmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['name'] = $row['name'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
                
            }
            $db->next_result();
            echo "<div class='prevcommentfloater'>";
            echo "<div class = 'prevcommenthead'>";
            echo "<div class = 'prevcommentrow'>";
            echo "<div class = 'commenterpic'>";
            echo profilepic::getPic(31, $comment[$r]['img']);
            echo "</div>";  //closes commenterpic
            echo "<div class = 'commentername'>";
            if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                
            } elseif ($comment[$r]['type'] == 10) {
                //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            } else {
                echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            }
            echo "</div>"; //closes commentername
            echo "</div>"; //closes prevcommentrow
            echo "</div>"; //closes commenthead
            echo "</div>"; //closes floater
            echo "<div class='prevcommentfloater'>";
            //echo "</div>";
            echo "<div class = 'commenttext'>";
            echo "<p>".$comment[$r]['text']."</p>";
            echo "</div>";
            echo "</div>";
            //echo "</div>";
            //echo "</div>";
            //echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <div class='regpostfloater'>
    <div class='commentdiv>'>
    <div class = 'comment'>
    <div class = 'commentpic'>
    <?php
        echo profilepic::getProfilePic(40);
        ?>
    </div> <!--closes commentpic-->
    <form method='post' action='submitcomment.php' name='commentform' id='commentform'>
    <div class='insertcomment'>
    <input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete="off">
    </div> <!--closes insertcomment-->
    <input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    </form>
    </div> <!--closes comment-->
    </div> <!--closes commentdiv-->
    </div> <!--closes regpostfloater-->
    <?php
    
    } elseif ($store[$i]['type'] == 6 && $store[$i]['poster'] != null) {
        
        $posterfname;
        $posterlname;
        $poster = $store[$i]['poster'];
        $posterpic;
        
        if ($call = mysqli_query($db, "CALL getBasicInfo($poster)")) {
            while ($row = mysqli_fetch_array($call)) {
                $posterfname = $row['firstname'];
                $posterlname = $row['lastname'];
                $posterpic = $row['img_filepath'];
            }
            $call->free();
            $db->next_result();
        }
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getProfilePic(50);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='profilepage.php'>".$posterfname." ".$posterlname."</a><br>".$time_elapse[$i]."</p>";
        echo "</div>"; //closes postname
        echo "</div>"; //closes postpic
        echo "</div>"; //closes head
        // echo "</div>"; //closes floater
        //            echo "</div>"; //closes regposts
        echo "<div class='regpostfloater'>";
        echo "<div class = 'posttext'>";
        echo $store[$i]['text'];
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        //echo $store[$i]['img'];
        echo "<div class='regpostfloater'>";
        echo "<div class='videodiv'>";
        echo "<video width = '460' height='300' preload='auto' controls>";
        ?>
<source src="<?php echo $store[$i]['img']; ?>" type='video/mp4'>

<!--//echo "<source src='uploads/1501835232.MOV' type='video/mp4'>"; -->
</video>
</div> <!-- closes videodiv -->
</div> <!-- closes floater -->

<?php
if ($userLike == true) {
    
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
    //$query = http_build_query($query);
    //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
    echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
    
} else {
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
//     //$query = http_build_query($query);
    //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
    echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
}
    if ($comm == true) {
        echo "<div class='regpostfloater'>";
        echo "<div class = 'prevcomments'>";
        
        echo "<div class = 'prevcommentsdiv'>";
        //echo $cind;
        $comment = $comment;
        for ($r = 0; $r < $cind; $r++) {
            $commenter_id = $comment[$r]['userID'];
            //echo "loop";
            if ($comment[$r]['type'] == 5) {
                // echo "hi";
                $basicinfo->bind_param("i", $commenter_id);
                $basicinfo->execute();
                $result = $basicinfo->get_result();

                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['firstname'] = $row['firstname'];
                    $comment[$r]['lastname'] = $row['lastname'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
            } elseif ($comment[$r]['type'] == 10) {
                
                $groupstmt->bind_param("i", $commenter_id);
                $groupstmt->execute();
                $result = $groupstmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['name'] = $row['name'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
                
            }
            $db->next_result();
            echo "<div class='prevcommentfloater'>";
            echo "<div class = 'prevcommenthead'>";
            echo "<div class = 'prevcommentrow'>";
            echo "<div class = 'commenterpic'>";
            echo profilepic::getPic(31, $comment[$r]['img']);
            echo "</div>";  //closes commenterpic
            echo "<div class = 'commentername'>";
            if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                
            } elseif ($comment[$r]['type'] == 10) {
                //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            } else {
                echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            }
            echo "</div>"; //closes commentername
            echo "</div>"; //closes prevcommentrow
            echo "</div>"; //closes commenthead
            echo "</div>"; //closes floater
            echo "<div class='prevcommentfloater'>";
            //echo "</div>";
            echo "<div class = 'commenttext'>";
            echo "<p>".$comment[$r]['text']."</p>";
            echo "</div>";
            echo "</div>";
            //echo "</div>";
            //echo "</div>";
            //echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    //echo "</div>";
    //echo "</div>";
    //echo "</div>";
    //echo "</div>";
    //echo "</div>"; //closes floater
    ?>
    <div class='regpostfloater'>
    <div class='commentdiv>'>
    <div class = 'comment'>
    <div class = 'commentpic'>
    <?php
        echo profilepic::getProfilePic(40);
        ?>
    </div> <!--closes commentpic-->
    <form method='post' action='submitcomment.php' name='commentform' id='commentform'>
    <div class='insertcomment'>
    <input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete="off">
    </div> <!--closes insertcomment-->
    <input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    <input type='hidden' value="1" name="page" id="page">
    </form>
    </div> <!--closes comment-->
    </div> <!--closes commentdiv-->
    </div> <!--closes regpostfloater-->
    <?php
    
    } elseif ($store[$i]['type'] == 2) {

        if ($hasLimit) {
            if ($race10) {
                if ($raceCount < $raceLimit) {
                    $raceCount++;
                } else {
                    $toDisplay = false;
                }
            } else {
                $toDisplay = false;
            }
        }
        if ($toDisplay) {        
        switch (intval($store[ri][7])) {
            case 1:
                $relay = "Yes";
                break;
            case 0:
                $relay = "No";
                break;
            default:
                $relay = "Unspecified";
                break;
        }
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getProfilePic(50);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='#'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i];
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        echo "<div class='profileposts'>";
        echo "<div class='raceposts'>";
        echo "<p>Name: ".$store[$i]['racename']."<br>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>Distance: ".$store[$i]['distance']." miles<br>Time: ".$store[$i]['runtime']."<br>Pace: ".$store[$i]['pace']."<br>Journal: ".$store[$i]['journal']."</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
        if ($userLike == true) {
    
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
            //$query = http_build_query($query);
            //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
            echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
    
        } else {
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
        //     //$query = http_build_query($query);
            //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
            echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
        }
        if ($comm == true) {
            echo "<div class='regpostfloater'>";
            echo "<div class = 'prevcomments'>";
        
            echo "<div class = 'prevcommentsdiv'>";
            //echo $cind;
            $comment = $comment;
        
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                if ($comment[$r]['type'] == 5) {
                    // echo "hi";
                    $basicinfo->bind_param("i", $commenter_id);
                    $basicinfo->execute();
                    $result = $basicinfo->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $comment[$r]['firstname'] = $row['firstname'];
                        $comment[$r]['lastname'] = $row['lastname'];
                        $comment[$r]['img'] = $row['img_filepath'];
                    }
                } elseif ($comment[$r]['type'] == 10) {
                
                    $groupstmt->bind_param("i", $commenter_id);
                    $groupstmt->execute();
                    $result = $groupstmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $comment[$r]['name'] = $row['name'];
                        $comment[$r]['img'] = $row['img_filepath'];
                    }
                
                }
                $db->next_result();
                echo "<div class='prevcommentfloater'>";
                echo "<div class = 'prevcommenthead'>";
                echo "<div class = 'prevcommentrow'>";
                echo "<div class = 'commenterpic'>";
                echo profilepic::getPic(31, $comment[$r]['img']);
                echo "</div>";  //closes commenterpic
                echo "<div class = 'commentername'>";
                if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                    echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                    
                } elseif ($comment[$r]['type'] == 10) {
                    //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                } else {
                    echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                }
                echo "</div>"; //closes commentername
                echo "</div>"; //closes prevcommentrow
                echo "</div>"; //closes commenthead
                echo "</div>"; //closes floater
                echo "<div class='prevcommentfloater'>";
                //echo "</div>";
                echo "<div class = 'commenttext'>";
                echo "<p>".$comment[$r]['text']."</p>";
                echo "</div>";
                echo "</div>";
        
            } //closes for loop
            echo "</div>"; //closes div 'prevcomments'
            echo "</div>"; //closes div 'regpost'
    
            echo "</div>"; //closes floater
        }
        
        
        echo "<div class='regpostfloater'>";
        ?>
<div class='commentdiv>'>
<div class = 'comment'>
<div class = 'commentpic'>
<?php
    echo profilepic::getProfilePic(40);
    ?>
</div> <!-- closes commentpic-->
<form method='post' action='submitcomment.php' name='commentform' id='commentform'>
<div class='insertcomment'>
<input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete="off">
</div> <!-- closes insertcomment -->
<input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
<input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
<input type='hidden' value="1" name="page" id="page">
</form>
</div> <!-- closes comment -->
</div> <!-- closes commentdiv -->
<?php
    echo "</div>"; //closes floater
    echo "</div>";
    }
    } elseif ($store[$i]['type'] == 1) {
        if ($hasLimit) {
            if ($speed10) {
                if ($speedCount < $speedLimit) {
                    $speedCount++;
                } else {
                    $toDisplay = false;
                }
            } else {
                $toDisplay = false;
            }
        }
        if ($toDisplay) {
            $type = $store[$i]['type'];
            if ($type == 0) {
                switch ($store[$i]['intensity']) {
                    case 1:
                        $strinten = "Low";
                        break;
                    case 2:
                        $strinten = "Between Low and Medium";
                        break;
                    case 3:
                        $strinten = "Medium";
                        break;
                    case 4:
                        $strinten = "Between Medium and High";
                        break;
                    case 5:
                        $strinten = "High";
                        break;
                    default:
                        $strinten = "Unspecified";
                        break;//07/07/2007
                }  //closes switch
            }
            echo "<div class='regposts'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='regposthead'>";
            echo "<div class='postpic'>";
            echo profilepic::getProfilePic(50);
            echo "</div>"; //closes postpic
            echo "<div class='postname'>";
            echo "<p><a href='#'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i];
            if ($store[$i]['userID'] == $cid) {
                //enable user to edit post
                echo "</div>"; //closes postname
                echo "<div class='editpost'>";
                $postid = $store[$i]['id'];
                $query = array('type' => $posttype, 'postid' => $postid);
                $query = http_build_query($query);
                echo "<a href='editpost.php?$query'>Edit</a>";
                echo "</div>"; //closes editpost
            } else {
                echo "</div>"; //closes postname
            }
            //echo "</div>"; //closes postname
            echo "</div>"; //closes head
            echo "</div>"; //closes floater
            echo "<div class='regpostfloater'>";
            if ($posttype == 0)
                echo "<div class='profileposts'>";
            elseif ($posttype == 1)
                echo "<div class='speedposts'>";
            echo "<div class='pptext'>";
            if ($type == 0) {
                echo "<p>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>With: ".$store[$i]['team']."<br>Distance: ".$store[$i]['distance']." miles<br>Time: ".$store[$i]['runtime']."<br>Pace: ".$store[$i]['pace']." min/mile<br>Intensity: ".$strinten."<br>Notes: ".trim($store[$i]['journal'])."</p>";
            } elseif ($type == 1) {
                echo "<p>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>With: ".$store[$i]['team']."<br>Distance: ".$store[$i]['distance']." miles<br>Description: ".$store[$i]['description']."<br>Notes: ".trim($store[$i]['journal'])."</p>";
            }
            echo "</div>";
            echo "</div>"; //closes profileposts
            echo "</div>"; //closes floater
            
            
        //echo "</div>"; //closes floater
        //echo "</div>";
        if ($userLike == true) {
        
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
            //$query = http_build_query($query);
            //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
            echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
        
        } else {
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
        //     //$query = http_build_query($query);
            //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
            echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
        }
        if ($comm == true) {
            echo "<div class='regpostfloater'>";
            echo "<div class = 'prevcomments'>";
            
            echo "<div class = 'prevcommentsdiv'>";
            //echo $cind;
            $comment = $comment;
            
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                if ($comment[$r]['type'] == 5) {
                    // echo "hi";
                    $basicinfo->bind_param("i", $commenter_id);
                    $basicinfo->execute();
                    $result = $basicinfo->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $comment[$r]['firstname'] = $row['firstname'];
                        $comment[$r]['lastname'] = $row['lastname'];
                        $comment[$r]['img'] = $row['img_filepath'];
                    }
                } elseif ($comment[$r]['type'] == 10) {
                    
                    $groupstmt->bind_param("i", $commenter_id);
                    $groupstmt->execute();
                    $result = $groupstmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $comment[$r]['name'] = $row['name'];
                        $comment[$r]['img'] = $row['img_filepath'];
                    }
                    
                }
                $db->next_result();
                echo "<div class='prevcommentfloater'>";
                echo "<div class = 'prevcommenthead'>";
                echo "<div class = 'prevcommentrow'>";
                echo "<div class = 'commenterpic'>";
                echo profilepic::getPic(31, $comment[$r]['img']);
                echo "</div>";  //closes commenterpic
                echo "<div class = 'commentername'>";
                if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                    echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                    
                } elseif ($comment[$r]['type'] == 10) {
                    //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                } else {
                    echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                }
                echo "</div>"; //closes commentername
                echo "</div>"; //closes prevcommentrow
                echo "</div>"; //closes commenthead
                echo "</div>"; //closes floater
                echo "<div class='prevcommentfloater'>";
                //echo "</div>";
                echo "<div class = 'commenttext'>";
                echo "<p>".$comment[$r]['text']."</p>";
                echo "</div>";
                echo "</div>";
                //echo "</div>";
            } //closes for loop
            
            //echo "</div>";
            //echo "</div>";
            echo "</div>"; //closes floater
            echo "</div>"; //closes regpost
            echo "</div>";
            //echo "</div>";
        } //closes if statement
        //echo "</div>";
        //echo "</div>";
        
            echo "<div class='regpostfloater'>";
            ?>
    <div class='commentdiv>'>
    <div class = 'comment'>
    <div class = 'commentpic'>
    <?php
        echo profilepic::getProfilePic(40);
        ?>
    </div> <!-- closes commentpic-->
    <form method='post' action='submitcomment.php' name='commentform' id='commentform'>
    <div class='insertcomment'>
    <input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete="off">
    </div> <!-- closes insertcomment -->
    <input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    <input type='hidden' value="1" name="page" id="page">
    </form>
    </div> <!-- closes comment -->
    </div> <!-- closes commentdiv -->
    <?php
        echo "</div>"; //closes floater
        echo "</div>";
        } 
    } elseif ($store[$i]['type'] == 0) {
        if ($hasLimit) {
            if ($dist10) {
                if ($distCount < $distLimit) {
                    $distCount++;
                } else {
                    $toDisplay = false;
                }
            } else {
                $toDisplay = false;
            }
        }
        if ($toDisplay) { 
        $type = $store[$i]['type'];
            if ($type == 0) {
            switch ($store[$i]['intensity']) {
                case 1:
                    $strinten = "Low";
                    break;
                case 2:
                    $strinten = "Between Low and Medium";
                    break;
                case 3:
                    $strinten = "Medium";
                    break;
                case 4:
                    $strinten = "Between Medium and High";
                    break;
                case 5:
                    $strinten = "High";
                    break;
                default:
                    $strinten = "Unspecified";
                    break;//07/07/2007
            }  //closes switch
        }
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getProfilePic(50);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='#'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i];
        if ($store[$i]['userID'] == $cid) {
            //enable user to edit post
            echo "</div>"; //closes postname
            echo "<div class='editpost'>";
            $postid = $store[$i]['id'];
            $query = array('type' => $posttype, 'postid' => $postid);
            $query = http_build_query($query);
            echo "<a href='editpost.php?$query'>Edit</a>";
            echo "</div>"; //closes editpost
        } else {
            echo "</div>"; //closes postname
        }
        //echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        if ($posttype == 0)
            echo "<div class='profileposts'>";
        elseif ($posttype == 1)
            echo "<div class='speedposts'>";
        echo "<div class='pptext'>";
        if ($type == 0) {
            echo "<p>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>With: ".$store[$i]['team']."<br>Distance: ".$store[$i]['distance']." miles<br>Time: ".$store[$i]['runtime']."<br>Pace: ".$store[$i]['pace']." min/mile<br>Intensity: ".$strinten."<br>Notes: ".trim($store[$i]['journal'])."</p>";
        } elseif ($type == 1) {
            echo "<p>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>With: ".$store[$i]['team']."<br>Distance: ".$store[$i]['distance']." miles<br>Description: ".$store[$i]['description']."<br>Notes: ".trim($store[$i]['journal'])."</p>";
        }
        echo "</div>";
        echo "</div>"; //closes profileposts
        echo "</div>"; //closes floater
        
        
    //echo "</div>"; //closes floater
    //echo "</div>";
    if ($userLike == true) {
    
        echo "<div class='likepostfloater'>";
        echo "<div class='likeable'>";
        // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
        //$query = http_build_query($query);
        //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
        echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
        echo "</div>"; //closes likeable
        echo "</div>"; //closes floater
    
    } else {
        echo "<div class='likepostfloater'>";
        echo "<div class='likeable'>";
        // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
    //     //$query = http_build_query($query);
        //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
        echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
        echo "</div>"; //closes likeable
        echo "</div>"; //closes floater
    }
    if ($comm == true) {
        echo "<div class='regpostfloater'>";
        echo "<div class = 'prevcomments'>";
        
        echo "<div class = 'prevcommentsdiv'>";
        //echo $cind;
        $comment = $comment;
        
        for ($r = 0; $r < $cind; $r++) {
            $commenter_id = $comment[$r]['userID'];
            //echo "loop";
            if ($comment[$r]['type'] == 5) {
                // echo "hi";
                $basicinfo->bind_param("i", $commenter_id);
                $basicinfo->execute();
                $result = $basicinfo->get_result();

                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['firstname'] = $row['firstname'];
                    $comment[$r]['lastname'] = $row['lastname'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
            } elseif ($comment[$r]['type'] == 10) {
                
                $groupstmt->bind_param("i", $commenter_id);
                $groupstmt->execute();
                $result = $groupstmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['name'] = $row['name'];
                    $comment[$r]['img'] = $row['img_filepath'];
                }
                
            }
            $db->next_result();
            echo "<div class='prevcommentfloater'>";
            echo "<div class = 'prevcommenthead'>";
            echo "<div class = 'prevcommentrow'>";
            echo "<div class = 'commenterpic'>";
            echo profilepic::getPic(31, $comment[$r]['img']);
            echo "</div>";  //closes commenterpic
            echo "<div class = 'commentername'>";
            if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                
            } elseif ($comment[$r]['type'] == 10) {
                //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            } else {
                echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
            }
            echo "</div>"; //closes commentername
            echo "</div>"; //closes prevcommentrow
            echo "</div>"; //closes commenthead
            echo "</div>"; //closes floater
            echo "<div class='prevcommentfloater'>";
            //echo "</div>";
            echo "<div class = 'commenttext'>";
            echo "<p>".$comment[$r]['text']."</p>";
            echo "</div>";
            echo "</div>";
            //echo "</div>";
        } //closes for loop
        
        //echo "</div>";
        //echo "</div>";
        echo "</div>"; //closes floater
        echo "</div>"; //closes regpost
        echo "</div>";
        //echo "</div>";
    } //closes if statement
    //echo "</div>";
    //echo "</div>";
    
        echo "<div class='regpostfloater'>";
        ?>
<div class='commentdiv>'>
<div class = 'comment'>
<div class = 'commentpic'>
<?php
    echo profilepic::getProfilePic(40);
    ?>
</div> <!-- closes commentpic-->
<form method='post' action='submitcomment.php' name='commentform' id='commentform'>
<div class='insertcomment'>
<input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete="off">
</div> <!-- closes insertcomment -->
<input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
<input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
<input type='hidden' value="1" name="page" id="page">
</form>
</div> <!-- closes comment -->
<! --</div> <!-- closes commentdiv -->
<?php
    
    echo "</div>";
   echo "</div>"; //closes floater
   echo "</div>";
    }
    } elseif ($store[$i]['type'] == 4) { //PAGEPOSTS (a post from one user onto this page)
        //echo "here";
        //$poster = $store[$i][''];
        //echo $poster;
        $pfirstname;
        $plastname;
        $posterprofpic;
        
        $basicinfo->bind_param("i", $poster);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        
        while ($row = $result->fetch_array()) {
            $pfirstname = $row['firstname'];
            $plastname = $row['lastname'];
            $posterprofpic = $row['img_filepath'];
        }
        $db->next_result();
        
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterprofpic);
        echo "</div>"; //closes pic
        echo "<div class='postname'>";
        echo "<a href='viewprofile.php?id=$poster'><p>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        echo "<div class='posttext'>";
        echo "<p>".$store[$i]['text']."</p>";
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        
        if ($store[$i]['img'] != null) {
            echo "<div class='regpostfloater'>";
            echo "<div class='regpostpic'>";
            echo profilepic::getPic(460, $store[$i]['img']);
            echo "</div>";
            echo "</div>"; //closes floater
        }
        //echo "<div class='regpostfloater'>";
        //echo "<div class='commentdiv>";
        
        if ($userLike == true) {
    
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
            //$query = http_build_query($query);
            //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
            echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
    
        } else {
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
        //     //$query = http_build_query($query);
            //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
            echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$poster,$i)'>Like</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
        }
        if ($comm == true) {
            echo "<div class='regpostfloater'>";
            echo "<div class = 'prevcomments'>";
            
            echo "<div class = 'prevcommentsdiv'>";
            //echo $cind;
            $comment = $comment;
            
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                
                if ($comment[$r]['type'] == 5) {
                    // echo "hi";
                    $basicinfo->bind_param("i", $commenter_id);
                    $basicinfo->execute();
                    $result = $basicinfo->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $comment[$r]['firstname'] = $row['firstname'];
                        $comment[$r]['lastname'] = $row['lastname'];
                        $comment[$r]['img'] = $row['img_filepath'];
                    }
                } elseif ($comment[$r]['type'] == 10) {
                
                    $groupstmt->bind_param("i", $commenter_id);
                    $groupstmt->execute();
                    $result = $groupstmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $comment[$r]['name'] = $row['name'];
                        $comment[$r]['img'] = $row['img_filepath'];
                    }
                
                }
                $db->next_result();
                echo "<div class='prevcommentfloater'>";
                echo "<div class = 'prevcommenthead'>";
                echo "<div class = 'prevcommentrow'>";
                echo "<div class = 'commenterpic'>";
                echo profilepic::getPic(31, $comment[$r]['img']);
                echo "</div>";  //closes commenterpic
                echo "<div class = 'commentername'>";
                if ($commenter_id != $cid && $comment[$r]['type'] == 5) {
                    echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                    
                } elseif ($comment[$r]['type'] == 10) {
                    //echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                echo "<p><a href='viewgroup.php?id=$commenter_id'>".$comment[$r]['name']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                } else {
                    echo "<p><a href='profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
                }
                echo "</div>"; //closes commentername
                echo "</div>"; //closes prevcommentrow
                echo "</div>"; //closes commenthead
                echo "</div>"; //closes floater
                echo "<div class='prevcommentfloater'>";
                //echo "</div>";
                echo "<div class = 'commenttext'>";
                echo "<p>".$comment[$r]['text']."</p>";
                echo "</div>";
                echo "</div>";
                //echo "</div>";
            } //closes for loop
            
            echo "</div>";
            echo "</div>";
            echo "</div>"; //closes floater
            //echo "</div>"; //closes regpost
        }
            
            echo "<div class='regpostfloater'>";
            echo "<div class='comment'>";
            
            echo "<div class='commentpic'>";
            echo profilepic::getProfilePic(31, $basic[4]);
            echo "</div>"; //closes commentpic

            ?>
    <form method='post' action='submitcomment.php' name='commentform' id='commentform'>
    <div class='insertcomment'>
    <input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete="off">
    <input type='hidden' value="<?php echo $store[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $store[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    <input type='hidden' value="1" name="page" id="page">
    </form>
    <?php
            echo "</div>"; //closes comment
            echo "</div>"; //closes commentdiv
            echo "</div>"; //closes floater
        } //closes if statement
       // echo "</div>"; //closes regposts
    
        //}
    $i++;
}
unset($basicinfo);
unset($likestmt);
unset($comstmt);
unset($store);
unset($basic);
unset($like);
unset($time_elapse);
unset($comment);
unset($result);
unset($row);
// echo memory_get_usage();
// echo "<br>".memory_get_peak_usage();
    ?>
</div>
</div>
</body>
</html>
