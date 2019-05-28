<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    //include 'mileage.php';
    
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>View Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    $basic = array();
    $mileage = 0;
    $weekmil = 0;
    $monthmil=0;
    $yearmil=0;
    $index = 0;
    //echo date("m/d/Y g:i a");
    //    include 'getraces.php';
    //    list($store,$index) = races::getraces();
    //    include 'getdistance.php';
    //    list($store,$index) = distance::getdistance($store,$index);
    //$db = mysqli_connect('localhost','gclog','d88ws12lls34*&3%%kL','Webhost') or die("no connection");
    $store = array();
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    //$id = $_SESSION['postee'];
    if ($call=mysqli_query($db,"CALL getBasicInfo('$id')")) {
        if ($row=mysqli_fetch_array($call, MYSQLI_NUM)) {
            $fields = mysqli_num_fields($call);
            for ($f=0;$f<$fields;$f++) {
                $basic[$f] = $row[$f];
            }
            $bi++;
        }
        $call->free();
        $db->next_result();
    }
    $findex = 0;
    $friends = array();
    if ($call=mysqli_query($db, "CALL GetAllFriends($id)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            if (intval($row['person1']) != intval($id)) {
                $friends[$findex]['id'] = $row['person1'];
                $friends[$findex]['sender'] = false;
            } else {
                $friends[$findex]['id'] = $row['person2'];
                $friends[$findex]['sender'] = true;
            }
            $friends[$findex]['status'] = $row['status'];
            $findex++;
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getfriends: ".mysqli_error($db);
    }
    $myfriend = -1;
    $sender = false;
    for ($f=0; $f<$findex; $f++) {
        if (intval($friends[$f]['id']) == intval($cid)) {
            $myfriend = intval($friends[$f]['status']);
            $sender = $friends[$f]['sender'];
        }
    }
    if ($myfriend == 2) {
        // echo "here";
        
        include "feedloader.php";
        $action = new FeedLoader();
        
        $diststmt = $db->prepare("CALL GETDISTANCE(?)");
        $racestmt = $db->prepare("CALL GETRACES(?)");
        $poststmt = $db->prepare("CALL GETUSERPOSTS(?)");
        $pgpoststmt = $db->prepare("CALL GETPAGEPOSTS(?)");
        $repoststmt = $db->prepare("CALL GETREPOSTS(?)");
        $speedstmt = $db->prepare("CALL GETSPEED(?)");
    
        //load the user's posts into store
        list($store, $index) = $action->loadFeed($id, $store, $index, $speedstmt, $diststmt, $racestmt, $poststmt, $pgpoststmt, $repoststmt, $db);
        
        
        //list($yearmil,$monthmil,$weekmil) = mileage::getmileages($store);
    }
    
    //        echo "<div class='milesdiv'>";
    //        echo "Total Miles<br>This Year: ".$yearmil."&nbsp This Month: ".$monthmil."&nbsp This Week: ".$weekmil;
    //        echo "</div>";
    include 'menu.php';
    //echo "</div>";
    ?>
</div>
</header>
<body>
<div class="content">
<div class="profilecol">
<div class="profilepic">
<?php
    echo profilepic::getPic(150, trim($basic[4]));
    ?>
</div>
<div class="biography">
<?php
    
    echo trim($basic[9]);
    ?>
</div>
</div>
<script>
    function undoDelete(userid) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "friendaction.php?action=" + 2 + "&user=" + userid);
        xmlhttp.send();
        window.location.href="viewprofile.php?id="+userid;

// window.location.href="friendaction.php?action=" + 2 + "&user=" + userid;
    }
function sendRequest() {
    window.location.href="sendrequest.php?id=<?php echo $id; ?>&page=viewprofile.php";
}
function cancelRequest() {
    window.location.href="cancelrequest.php?id=<?php echo $id; ?>&page=viewprofile.php";
}
function acceptRequest() {
    window.location.href="acceptrequest.php?id=<?php echo $id; ?>&page=1";
}
function undoDeny() {
    window.location.href="undodeny.php?id=<?php echo $id; ?>&page=1";
}
function denyRequest() {
    window.location.href="denyrequest.php?id=<?php echo $id; ?>&page=1";
}
</script>
<?php
    
    if (intval($myfriend) == -1) {
        ?>
        <div class='notfriends'>
        <div class='regpostfloater'>
        <div class='sendrequest'>
        You are not friends with <?php echo trim($basic[5]); ?> <?php echo trim($basic[6]); ?>
        <input type='button' value="Send Request" name="sendreq" id="sendreq" onclick="sendRequest()">
       </div> <!-- closes sendRequest-->
        </div> <!-- closes regpostfloater -->
        </div> <!-- closes not friends -->
<?php
    } elseif ($myfriend == 5 && $sender == false) {
        ?>
        <div class='notfriends'>
        <div class='regpostfloater'>
        <div class='sendrequest'>
        You deleted this user
        <?php
        echo "<input type='button' value='Undo' name='sendreq' id='sendreq' onclick='undoDelete($id)'>";
        ?>
       </div> <!-- closes sendRequest-->
        </div> <!-- closes regpostfloater -->
        </div> <!-- closes not friends -->
        <?php
    } elseif ($myfriend == 4 && $sender == true) {
        //they deleted me, do nothing
    } elseif ($myfriend == 5 && $sender == true) {
        //they deleted me, do nothing
    } elseif ($myfriend == 4 && $sender == false) {
        
        echo "<div class='notfriends'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='sendrequest'>";
        echo "You deleted this user";
        echo "<input type='button' value='Undo' name='sendreq' id='sendreq' onclick='undoDelete($id)'>";
        echo "</div>";// <!-- closes sendRequest-->
        echo "</div>";// <!-- closes regpostfloater -->
        echo "</div>";// <!-- closes not friends -->
        
    } elseif ($myfriend == 3) {
        if ($sender == true) {
            echo "<div class='notfriends'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='sendrequest'>";
            echo "You denied ".trim($basic[5])." ".trim($basic[6])." request<br>";
            ?>
<input type='button' value='undo' name='btnundo' id='btnundo' onclick="undoDeny()">
<?php
            echo "</div>";
            echo "</div>"; //closes floater
            echo "</div>"; //closes notfriends
        }
        
    } elseif (intval($myfriend) == 0) {
        $waiting = false;
        if ($call = mysqli_query($db, "CALL GetSender('$cid','$id')")) {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            if ($cid == $row['person1']) {
                $waiting = true;
            }
            $call->free();
            $db->next_result();
        }
        
        if ($waiting == true) {
            echo "<div class='notfriends'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='sendrequest'>";
            echo "Friend Request Pending<br>";
            ?>
<input type='button' value="Cancel Request" name="cancelreq" id="cancelreq" onclick="cancelRequest()">
<?php
            echo "</div>"; //closes sendrequest
            echo "</div>"; //closes floater
            echo "</div>"; //closes notfriends
    } else {
        echo "<div class='notfriends'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='sendrequest'>";
        echo trim($basic[5])." ".trim($basic[6])." wants to friend you<br>";
        ?>
<input type='button' value="Accept" name="acceptreq" id="acceptreq" onclick="acceptRequest()">
<input type='button' value="Deny" name="denyreq" id="denyreq" onclick="denyRequest()">
<?php
        echo "</div>"; //closes sendrequest
        echo "</div>"; //closes floater
        echo "</div>"; //closes notfriends
    }
    } else {
        ?>
      
<div class="createpost">
<div class="opentext">
<form id="textform" name="textform" method="post" action="pagepost.php" enctype="multipart/form-data">
<?php
    echo "<textarea id='txtcontent' rows='3' cols = '38' name='content' placeholder='Post to $basic[5] $basic[6] page'></textarea>";
    ?>
<div class="postbuttons">
<input type="file" aria-label="Picture/Video" name="fileToUpload" id="fileToUpload">
<input type='hidden' value="<?php echo $id; ?>" name="postee" id="postee">
<input type='hidden' value="<?php echo $cid; ?>" name="encid" id="encid">
<input type='hidden' value='4' name='type' id='type'>
<input type="hidden" value="23" name="page" id="page">
<input type='submit' name="btnSubmitText" id="btnSubmitText" value="Post">
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
<?php
echo "<div class='profilefeed'>";
    $time_elapse = array();
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) < strtotime($b['date']);
    }
    usort($store, "datesort");
    //$store = arsort($store);
    // $_SESSION['postID']
    
    
    //  Start "unwrapping" the profile page feed
    include "elapsedtime.php";
    
    $basicinfo = $db->prepare("CALL GETBASICINFO(?)");
    $likestmt = $db->prepare("CALL GETLIKES(?,?)");
    $comstmt = $db->prepare("CALL GETCOMMENTS(?,?)");
    $groupstmt = $db->prepare("CALL GETGROUPINFO(?)");
    for ($i = 0; $i < $index; $i++) {
        $posttype = $store[$i]['type'];
        $postID = $store[$i]['id'];
        $poster = $store[$i]['userID'];
        //echo $posttype."<br>".$postID;
        //$number_comments = 0;
        $cind = 0;
        $comment = array();
        
        $comstmt->bind_param("ii", $posttype, $postID);
        $comstmt->execute();
        $result = $comstmt->get_result();
        
        
        while ($row = $result->fetch_assoc()) {
            
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
            
        $comm = true;
        if ($cind == 0) {
            $comm = false;
        }
        
        for ($ci = 0; $ci < $cind; $ci++) {
            $comment[$ci]['time_elapsed'] = elapsedtime::getElapsedTime($comment[$ci]['date']);
        }
        
        //get the likes for the post
        $like = array(); //ID of the like
        $likeIndex = 0;

        $likestmt->bind_param("ii", $posttype, $postID);
        $likestmt->execute();
        $result = $likestmt->get_result();
        
        
        while ($row = $result->fetch_assoc()) {
            //$like[$likeIndex]['id'] = $row['id'];
            $like[$likeIndex]['posterID'] = $row['posterID'];
            $like[$likeIndex]['likerID'] = $row['likerID'];
            $like[$likeIndex]['date'] = $row['date'];

            $likeIndex++;
            // echo "here1";
        }
        $db->next_result();
        
            
        $isLiked = false;
        if ($likeIndex > 0) {
            $isLiked = true;
        }
        
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
        
        
        $time_elapse[$i] = elapsedtime::getElapsedTime($store[$i]['date']);
        $strinten;
        $relay;
        if (intval($store[$i]['type']) == 3) { //POST result
            echo "<div class='regposts'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='regposthead'>";
            echo "<div class='postpic'>";
            echo profilepic::getPic(50, trim($basic[4]));
            echo "</div>"; //closes postpic
            echo "<div class='postname'>";
            echo "<p><a href='viewprofile.php?id=$id'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i];
            echo "</div>"; //closes postname
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
                echo "</div>";
                echo "</div>";
            }
                ?>

<?php
if ($userLike == true) {
    
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
    //$query = http_build_query($query);
    //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
    echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$id,$i)'>Liked</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
    
} else {
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
//     //$query = http_build_query($query);
    //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
    echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$id,$i)'>Like</button>";
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
    <input type='hidden' value="3" name='page' id='page'>
    <input type='hidden' value="<?php echo $poster; ?>" name='posterID' id='posterID'>
    </form>
    </div> <!-- close div comment -->
    </div> <!-- closes commentdiv-->
    </div> <!-- closes floater -->
    <?php
    echo "</div>";
    } elseif (intval($store[$i]['type']) == 4) { //PAGEPOST result
        //echo "here";
        $poster = $store[$i]['userID'];
        //echo $poster;
        $pfirstname;
        $plastname;
        $posterprofpic;
        
        $basicinfo->bind_param("i", $poster);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        
        while ($row = $result->fetch_assoc()) {
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
        
        if ($poster != $cid) { //redirect to a different profile page
            
            echo "<a href='viewprofile.php?id=$poster'><p>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        
        } else { //redirect to this user's profilepage
            
            echo "<a href='profilepage.php'><p>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
                        
        }
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
    <input type='hidden' value="3" name='page' id='page'>
    <input type='hidden' value="<?php echo $poster; ?>" name='posterID' id='posterID'>
    <input type='hidden' value="<?php echo $id; ?>" name='pageowner' id='pageowner'>
    </form>
    <?php
            echo "</div>"; //closes comment
            echo "</div>"; //closes commentdiv
            echo "</div>"; //closes floater
            //} //closes if statement
        echo "</div>"; //closes regposts
        
    } elseif ($store[$i]['type'] == 6 && $store[$i]['poster'] != null) { //video formatting
        
        $posterfname;
        $posterlname;
        $posterpic;
        $poster = $store[$i]['poster'];
        
        
        $basicinfo->bind_param("i", $poster);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $posterfname = $row['firstname'];
            $posterlname = $row['lastname'];
            $posterpic = $row['img_filepath'];
        }
        $db->next_result();
        
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='#'>".$posterfname." ".$posterlname."</a><br>".$time_elapse[$i];
        echo "</div>"; //closes postname
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
        echo "<video width = '460' height='300' controls>";
        ?>
<source src="<?php echo $store[$i]['img']; ?>" type='video/mp4'>

<!--//echo "<source src='uploads/1501835232.MOV' type='video/mp4'>"; -->
</video>
</div> <!-- closes videodiv -->
</div> <!-- closes floater -->
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
<input type='hidden' value="3" name='page' id='page'>
<input type='hidden' value="<?php echo $poster; ?>" name='posterID' id='posterID'>
</form>
</div> <!--closes comment-->
</div> <!--closes commentdiv-->
</div> <!--closes regpostfloater-->
<?php
if ($userLike == true) {
    
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
    //$query = http_build_query($query);
    //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
    echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$id,$i)'>Liked</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
    
} else {
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
//     //$query = http_build_query($query);
    //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
    echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$id,$i)'>Like</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
}
    if ($comm == true) {
        echo "<div class='regpostfloater'>";
        echo "<div class = 'prevcomments'>";
        
        echo "<div class = 'prevcommentsdiv'>";
        //echo $cind;
        usort($comment, "datesort");
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
        }
        //echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    //echo "</div>";
    //echo "</div>";
    //echo "</div>";
    //echo "</div>";
    echo "</div>"; //closes floater
    
} elseif ($store[$i]['type'] == 6 && $store[$i]['poster'] == null) {
    
    $user = $store[$i]['userID'];
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        if ($user != $cid) {
            echo "<p><a href='viewprofile.php?id=$user'>".$posterfname." ".$posterlname."</a><br>".$time_elapse[$i];
           
        } else {
            echo "<p><a href='profilepage.php'>".$posterfname." ".$posterlname."</a><br>".$time_elapse[$i];
        
        }
        echo "</div>"; //closes postname
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
        echo "<video width = '460' height='300' controls>";
        ?>
<source src="<?php echo $store[$i]['img']; ?>" type='video/mp4'>

<!--//echo "<source src='uploads/1501835232.MOV' type='video/mp4'>"; -->
</video>
</div> <!-- closes videodiv -->
</div> <!-- closes floater -->
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
<input type='hidden' value="0" name='page' id='page'>
<input type='hidden' value="<?php echo $poster; ?>" name='posterID' id='posterID'>
</form>
</div> <!--closes comment-->
</div> <!--closes commentdiv-->
</div> <!--closes regpostfloater-->
<?php
if ($userLike == true) {
    
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
    //$query = http_build_query($query);
    //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
    echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$id,$i)'>Liked</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
    
} else {
    echo "<div class='likepostfloater'>";
    echo "<div class='likeable'>";
    // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
//     //$query = http_build_query($query);
    //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
    echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$id,$i)'>Like</button>";
    echo "</div>"; //closes likeable
    echo "</div>"; //closes floater
}
    if ($comm == true) {
        echo "<div class='regpostfloater'>";
        echo "<div class = 'prevcomments'>";
        
        echo "<div class = 'prevcommentsdiv'>";
        //echo $cind;
        usort($comment, "datesort");
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
        }
        //echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    //echo "</div>";
    //echo "</div>";
    //echo "</div>";
    //echo "</div>";
    echo "</div>"; //closes floater
    
    

    } elseif ($store[$i]['type'] == 2) {
        switch (intval($store[$i][7])) {
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
        echo profilepic::getPic(50, trim($basic[4]));
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='viewprofile.php?id=$id'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i];
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
            
            echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$poster,$i)'>Liked</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
    
        } else {
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            
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
                // echo $comment[$r]['img'];
                echo profilepic::getPic(31, $comment[$r]['img']);
                // echo "here";
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
        echo "<div class='commentdiv>'>";
        echo "<div class = 'comment'>";
        echo "<div class = 'commentpic'>";
        echo profilepic::getProfilePic(40);
        echo "</div>";// <!-- closes commentpic-->
        echo "<form method='post' action='submitcomment.php' name='commentform' id='commentform'>";
        echo "<div class='insertcomment'>";
        echo "<input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30.5' autocomplete='off'>";
        echo "</div>";// <!-- closes insertcomment -->
        // echo "<input type='hidden' value='$postID' name = 'postID' id = 'postID'>";
//         echo "<input type='hidden' value='$posttype' name = 'ptype' id = 'ptype'>";
        echo "<input type='hidden' value='$postID' name = 'postID' id = 'postID'>";
        echo "<input type='hidden' value='$posttype' name = 'ptype' id = 'ptype'>";
        echo "<input type='hidden' value='0' name = 'page' id = 'page'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "</form>";
        echo "</div>";// <!-- closes comment -->
        echo "</div>";// <!-- closes commentdiv -->
        echo "</div>"; //closes floater
        echo "</div>";
    } elseif (($posttype == 0 || $posttype == 1) && $store[$i]['public'] == 1) {
        
        if ($posttype == 0) {
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
                    break;
            }
        }
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, trim($basic[4]));
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        
        echo "<p><a href='viewprofile.php?id=$id'>".$basic[5]." ".$basic[6]."</a><br>".$time_elapse[$i];
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        if ($posttype == 0)
            echo "<div class='profileposts'>";
        else
            echo "<div class='speedposts'>";
        if ($posttype == 0) {
            echo "<p>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>With: ".$store[$i]['team']."<br>Distance: ".$store[$i]['distance']." miles<br>Time: ".$store[$i]['runtime']."<br>Pace: ".$store[$i]['pace']." min/mile<br>Intensity: ".$strinten."<br>Notes: ".trim($store[$i]['journal'])."</p>";
        } elseif ($posttype == 1) {
            echo "<p>Date: ".$store[$i]['date']."<br>Location: ".$store[$i]['location']."<br>With: ".$store[$i]['team']."<br>Distance: ".$store[$i]['distance']." miles<br>Description: ".$store[$i]['description']."<br>Notes: ".trim($store[$i]['journal'])."</p>";
        }
        echo "</div>"; //closes profileposts
        echo "</div>"; //closes floater
        
        //echo "<div class='regpostfloater'>";
        ?>

<?php
    //echo "</div>"; //closes floater
    if ($userLike == true) {
    
        echo "<div class='likepostfloater'>";
        echo "<div class='likeable'>";
        // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
        //$query = http_build_query($query);
        //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
        echo "<button id='unlikeButton$i' onclick='unlikePost($posttype,$postID,$id,$i)'>Liked</button>";
        echo "</div>"; //closes likeable
        echo "</div>"; //closes floater
    
    } else {
        echo "<div class='likepostfloater'>";
        echo "<div class='likeable'>";
        // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
    //     //$query = http_build_query($query);
        //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
        echo "<button id='likeButton$i' onclick='likePost($postID,$posttype,$id,$i)'>Like</button>";
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
        }
        echo "</div>";
        echo "</div>";
        echo "</div>"; //closes floater
    }
    ?>
    <div class='regpostfloater'>
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
    <input type='hidden' value="3" name='page' id='page'>
    <input type='hidden' value="<?php echo $poster; ?>" name='posterID' id='posterID'>
    </form>
    </div> <!-- closes comment -->
    </div> <!-- closes commentdiv -->
</div>
    <?php
    
    echo "</div>"; //closes regposts
    }
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
}

    ?>
</div>
</div>
</body>
</html>
