<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    include 'feedloader.php';
    ?>
<!DOCTYPE html>
<html lang = "en">
<header>
    <script>
       function createProj(id) {
            window.location.href="createproject.php?id=" + id;
        }
        function reportBug(id) {
           window.location.href="reportgrpbug.php?id=" + id;
       }
       function hideJ(id) {
          window.location.href="viewgroup.php?id=" + id + "&window=2";
       }
       function showJ(id) {
           window.location.href="viewgroup.php?id=" + id + " &window=1";
       }
       function assign(id) {
            window.location.href="assignment.php?id=" + id;
       }
       function likePost(id,type,poster,compID) {
            var button = document.getElementById("likeButton" + compID);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "likepost.php?id=" + id + "&type=" + type + "&poster=" + poster);
            xmlhttp.send();
            button.id="unlikeButton"+compID;
            button.innerHTML = "liked";
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
        function acceptGroupRequest(groupID, sender) {
            window.location.href="acceptrequest.php?group=" + groupID + "&page=0&type=1&sender=" + sender;
        }
        function joingroup(groupid, cid) {
            window.location.href="acceptrequest.php?group=" + groupid + "&page=0&type=2";
        }
    </script>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<title>View Group</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    $window = isset($_GET['window']) ? $_GET['window'] : null;
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $sender = isset($_GET['sender']) ? $_GET['sender'] : null;
    $groupinfo = array();
    $members = array();
    $mindex = 0;
    $gindex = 0;
    if ($call = mysqli_query($db, "CALL GETGROUPINFO($id)")) {
        while ($row = mysqli_fetch_array($call)) {
            $groupinfo['name'] = $row['name'];
            $groupinfo['type'] = $row['type'];
            $groupinfo['policy'] = $row['policy'];
            $groupinfo['admin'] = $row['admin'];
            $groupinfo['location'] = $row['location'];
            $groupinfo['pagepolicy'] = $row['pagepolicy'];
            $groupinfo['img'] = $row['img_filepath'];
            $groupinfo['description'] = trim($row['description']);
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getgroupinfo: ".mysqli_error($db);
    }
    $type = $groupinfo['type'];
    if ($call = mysqli_query($db, "CALL GETGROUPMEMBERS($id)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $members[$mindex]['cryptID'] = $row['cryptID'];
            $members[$mindex]['permissions'] = $row['permissions'];
            
            $mindex++;
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getgroupmembers: ".mysqli_error($db);
    }
    
    //find out what kind of member this user is
    $searching = true;
    $membertype = -1;
    $i = 0;
    while ($i < $mindex && $searching) {
        if ($members[$i]['cryptID'] == $cid && $members[$i]['permissions'] < 9) {
            $searching = false;
            $membertype = $members[$i]['permissions'];
        }
        $i++;
    }
    ?>
</div>
</header>
<body>
<div class="content">
<div class="profilecol">
<div class="profilepic">
<?php
    echo profilepic::getPic(150, trim($groupinfo['img']));
    ?>
</div>
<div class="biography">
<?php

    echo trim($groupinfo['description']);
    ?>
</div>
<?php
if ($membertype == 3) { //this user can have access to the admin controls
    echo "<div class='profile_options'>";
    echo "<table>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>";
    echo "<a href='admintools.php?id=$id'>Admin Tools</a>";
    echo "</td>";
    echo "</tr>";
    echo "</tbody></table></div>";
} elseif ($membertype == 2) {
    echo "<div class='profile_options'>";
    echo "<table>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>";
    echo "<a href='admintools.php?id=$id'>Moderator Tools</a>";
    echo "</td>";
    echo "</tr>";
    echo "</tbody></table></div>";
} elseif ($membertype == 1 && ($groupinfo['policy'] == 1 || $groupinfo['policy'] == 2)) {
    echo "<div class='profile_options'>";
    echo "<table>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>";
    echo "<a href='invitefriends.php?id=$id'>Invite Friends</a>";
    echo "</td>";
    echo "</tr>";
    echo "</tbody></table></div>";
}
echo "</div>";
if ($searching) {
    echo "<div class='notfriends'>";
    echo "<div class='regpostfloater'>";
    // echo "<p>You are not in this group</p>";
    if ($groupinfo['policy'] == 1) {
        echo "<p>This is an open group</p><br><button id='btnJoinGroup' onclick='joingroup($id, $cid)'>Join Group</button>";
    } elseif ($sender != null) {
        $invites = array();
        $invIndex = 0;
        $invited = false;
        if ($call = mysqli_query($db, "CALL GETINVITATIONS($cid)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                if ($row['sender'] == $sender && $row['id'] = $id) {
                    $invited = true;
                }
            }
            $call->free();
            $db->next_result();
        }
        if ($invited) {
            $fname;
            $lname;
            if ($call = mysqli_query($db, "CALL GETBASICINFO($sender)")) {
                while ($row = mysqli_fetch_array($call)) {
                    $fname = $row['firstname'];
                    $lname = $row['lastname'];
                }
                $call->free();
                $db->next_result();
            } else {
                echo "45: ".mysqli_error($db);
            }
            echo "<p>".$fname." ".$lname." invited you to join</p><br>";
            echo "<button id='btnAcceptInvite' onclick='acceptInvitation($id, $sender)'>Join</button>";
        }
    } else {
        echo "</div>";
        echo "</div>";
    
    
        echo "<div class='notfriends'>";
        echo "<div class='regpostfloater'>";
        echo "<p>You are not in this group</p>";
        if ($groupinfo['policy'] == 1) {
            echo "<button id='btnJoinGroup' onclick='joingroup($id, $cid)'>Join Group</button>";
        }
        echo "</div>";
        echo "</div>";
    }
    
} else {
    $name = $groupinfo['name'];
    $pol = $groupinfo['pagepolicy'];
    echo "<div class='createpost'>";
    
    
 //   if ($window == null)
 //       echo "<button onclick='hideJ($id)'>Hide Journals</button>";
 //   elseif ($window == 2)
 //       echo "<button onclick='showJ($id)'>Show Journals</button>";
 //   elseif ($window == 1)
 //       echo "<button onclick='hideJ($id)'>Hide Journals</button>";
    
    
    echo "<div class='opentext'>";
    if ($type == 6) {
        echo "<button id='projBtn' name='projBtn' onClick='createProj($id)'>Create Project</button>";
        echo "<button id='issueBtn' name='issueBtn' onClick='reportBug($id)'>Report Bug</button><br>";
        echo "<button id='assignBtn' name='assignBtn' onClick='assign($id)'>Assign ToDo</button><br>";
    }
    echo "<form id='textform' name='textform' method='post' action='grouppagepost.php' enctype='multipart/form-data'>";
    
    echo "<textarea id='txtcontent' rows='3' cols = '38' name='content' placeholder='Post to $name'></textarea>";
       
    echo "<div class='postbuttons'>";
    echo "<input type='file' aria-label='Picture/Video' name='fileToUpload' id='fileToUpload'>";
    echo "<input type='hidden' value='$id' name='postee' id='postee'>";
    echo "<input type='hidden' value='$cid' name='encid' id='encid'>";
    echo "<input type='hidden' value='7' name='type' id='type'>"; //7 for group pageposts
    echo "<input type='hidden' value='2' name='page' id='page'>";
    echo "<input type='hidden' value='$membertype' name='membertype' id='membertype'>";
    echo "<input type='hidden' value='$pol' name='policy' id='policy'>";
    echo "<input type='submit' name='btnSubmitText' id='btnSubmitText' value='Post'>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    
    $groupfeed = array();
    $index = 0;
    if ($type != 6) {
        if ($call = mysqli_query($db, "CALL GETPAGEPOSTS($id)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $groupfeed[$index]['type'] = $row['type'];
                $groupfeed[$index]['userID'] = $row['poster'];
                $groupfeed[$index]['postee'] = $row['postee'];
                $groupfeed[$index]['id'] = $row['id'];
                $groupfeed[$index]['text'] = $row['text'];
                $groupfeed[$index]['img'] = $row['img_filepath'];
                $groupfeed[$index]['date'] = $row['date'];
                
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo "GETPAGEPOSTS: ".mysqli_error($db);
        }
        if ($call = mysqli_query($db, "CALL GETUSERPOSTS($id)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $groupfeed[$index]['type'] = $row['type'];
                $groupfeed[$index]['userID'] = $row['userID'];
                $groupfeed[$index]['id'] = $row['id'];
                $groupfeed[$index]['date'] = $row['date'];
                $groupfeed[$index]['text'] = $row['text'];
                $groupfeed[$index]['img'] = $row['img_filepath'];
                
                
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo "GETPAGEPOSTS: ".mysqli_error($db);
        }
        
        $diststmt = $db->prepare("CALL GETDISTANCE(?)");
        $racestmt = $db->prepare("CALL GETRACES(?)");
        $speedstmt = $db->prepare("CALL GETSPEED(?)");
        
        if ($window != 2) {
            for ($i = 0; $i < $mindex; $i++) {
                $memberID = $members[$i]['cryptID'];
        
                $action = new FeedLoader();
                list($groupfeed, $index) = $action->loadRuns($groupfeed, $diststmt, $racestmt, $speedstmt, $index, $db, $memberID);
                unset($action);
            }    
        }
    } else {
        if ($call = mysqli_query($db, "CALL GETUSERPOSTS($id)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $groupfeed[$index]['type'] = $row['type'];
                $groupfeed[$index]['userID'] = $row['userID'];
                $groupfeed[$index]['id'] = $row['id'];
                $groupfeed[$index]['date'] = $row['date'];
                $groupfeed[$index]['text'] = $row['text'];
                $groupfeed[$index]['img'] = $row['img_filepath'];
                
                
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo "GETPAGEPOSTS: ".mysqli_error($db);
        }
        if ($call = mysqli_query($db, "CALL GETPAGEPOSTS($id)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $groupfeed[$index]['type'] = $row['type'];
                $groupfeed[$index]['userID'] = $row['poster'];
                $groupfeed[$index]['postee'] = $row['postee'];
                $groupfeed[$index]['id'] = $row['id'];
                $groupfeed[$index]['text'] = $row['text'];
                $groupfeed[$index]['img'] = $row['img_filepath'];
                $groupfeed[$index]['date'] = $row['date'];
                
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo "GETPAGEPOSTS: ".mysqli_error($db);
        }
    }
}
?>

<?php
echo "<div class='profilefeed'>";
    $time_elapse = array();
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) < strtotime($b['date']);
    }
    usort($groupfeed, "datesort");
    //$groupfeed = arsort($groupfeed);
    // $_SESSION['postID']
    
    //  Start "unwrapping" the profile page feed
    include "elapsedtime.php";
    
    $comstmt = $db->prepare("CALL GETCOMMENTS(?,?)");
    $likestmt = $db->prepare("CALL GETLIKES(?,?)");
    $basicinfo = $db->prepare("CALL GETBASICINFO(?)");
    $groupstmt = $db->prepare("CALL GETGROUPINFO(?)");
    $memberstmt = $db->prepare("CALL GETMYGROUPS(?)");
    //loop
    for ($i = 0; $i < $index; $i++) {
        $posttype = $groupfeed[$i]['type'];
        $postID = $groupfeed[$i]['id'];
        $poster = $groupfeed[$i]['userID'];
        
        $posterprofpic;
        $pfirstname;
        $plastname;
         
        $basicinfo->bind_param("i", $poster);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        while ($row = $result->fetch_assoc()) {
            $pfirstname = $row['firstname'];
            $plastname = $row['lastname'];
            $posterprofpic = $row['img_filepath'];
        }
        $db->next_result();
        
        $memberstmt->bind_param("i", $poster);
        $memberstmt->execute();
        $result = $memberstmt->get_result();
        $permissions = -1;
        while ($row = $result->fetch_assoc()) {
            if ($row['groupID'] == $id) {
                $permissions = $row['permissions'];
            }
        }
        $db->next_result();

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
        
        
        $time_elapse[$i] = elapsedtime::getElapsedTime($groupfeed[$i]['date']);
        $strinten;
        $relay;
        
    if (intval($groupfeed[$i]['type']) == 7 && ($groupinfo['pagepolicy'] == 0 || $permissions >= 1) && $permissions < 9) { //PAGEPOST result
        // echo $permissions." ".$groupinfo['pagepolicy'];
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
        echo "<p>".$groupfeed[$i]['text']."</p>";
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        //echo "hi";
        if ($groupfeed[$i]['img'] != NULL) {
            echo "<div class='regpostfloater'>";
            echo "<div class='regpostpic'>";
            echo profilepic::getPic(460, $groupfeed[$i]['img']);
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
    <input type='hidden' value="<?php echo $groupfeed[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $groupfeed[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    <input type='hidden' value="4" name='page' id='page'>
    <input type="hidden" value='<?php echo $id; ?>' name="pageID" id="pageID">
    <input type='hidden' value="<?php echo $poster; ?>" name='posterID' id='posterID'>
    </form>
    <?php
            echo "</div>"; //closes comment
            echo "</div>"; //closes commentdiv
            echo "</div>"; //closes floater
            //} //closes if statement
        echo "</div>"; //closes regposts
        
    } elseif ($groupfeed[$i]['type'] == 6 && $groupfeed[$i]['poster'] != null && $permissions < 9) { //video formatting
        
        $pfirstname;
        $plastname;
        $posterpic;
        $poster = $groupfeed[$i]['poster'];
        
        if ($call=mysqli_query($db, "CALL getBasicInfo($poster)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $pfirstname = $row['firstname'];
                $plastname = $row['lastname'];
                $posterpic = $row['img_filepath'];
            }
            
            
            $call->free();
            $db->next_result();
        }
        
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='#'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i];
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        // echo "</div>"; //closes floater
        //            echo "</div>"; //closes regposts
        echo "<div class='regpostfloater'>";
        echo "<div class = 'posttext'>";
        echo $groupfeed[$i]['text'];
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        //echo $groupfeed[$i]['img'];
        echo "<div class='regpostfloater'>";
        echo "<div class='videodiv'>";
        echo "<video width = '460' height='300' controls>";
        ?>
<source src="<?php echo $groupfeed[$i]['img']; ?>" type='video/mp4'>

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
<input type='hidden' value="<?php echo $groupfeed[$i]['id']; ?>" name = 'postID' id = 'postID'>
<input type='hidden' value="<?php echo $groupfeed[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
<input type='hidden' value="4" name='page' id='page'>
<input type="hidden" value='<?php echo $id; ?>' name="pageID" id="pageID">
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
            
            if ($commenter_id != $cid) {
                echo "<p><a href = 'viewprofile.php?id=$commenter_id'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
           
            } else {
                echo "<p><a href = 'profilepage.php'>".$comment[$r]['firstname']." ".$comment[$r]['lastname']."</a><br>".$comment[$r]['time_elapsed']."</p>";
           
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
    
} elseif ($groupfeed[$i]['type'] == 6 && $groupfeed[$i]['poster'] == null) {
    
    $user = $groupfeed[$i]['userID'];
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        if ($user != $cid) {
            echo "<p><a href='viewprofile.php?id=$user'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i];
           
        } else {
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i];
        
        }
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        // echo "</div>"; //closes floater
        //            echo "</div>"; //closes regposts
        echo "<div class='regpostfloater'>";
        echo "<div class = 'posttext'>";
        echo $groupfeed[$i]['text'];
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        //echo $groupfeed[$i]['img'];
        echo "<div class='regpostfloater'>";
        echo "<div class='videodiv'>";
        echo "<video width = '460' height='300' controls>";
        ?>
<source src="<?php echo $groupfeed[$i]['img']; ?>" type='video/mp4'>

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
<input type='hidden' value="<?php echo $groupfeed[$i]['id']; ?>" name = 'postID' id = 'postID'>
<input type='hidden' value="<?php echo $groupfeed[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
<input type='hidden' value="4" name='page' id='page'>
<input type="hidden" value="<?php echo $id; ?>" name="pageID" id="pageID">
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
    
    

    } elseif ($groupfeed[$i]['type'] == 2 && $permissions < 9 && ($groupinfo['pagepolicy'] == 0 || $permissions >= 1)) {
        switch (intval($groupfeed[$i][7])) {
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
        echo profilepic::getPic(50, $posterprofpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        if ($poster == $cid)
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i];
        else
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i];
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        echo "<div class='profileposts'>";
        echo "<div class='raceposts'>";
        echo "<p>Name: ".$groupfeed[$i]['racename']."<br>Date: ".$groupfeed[$i]['date']."<br>Location: ".$groupfeed[$i]['location']."<br>Distance: ".$groupfeed[$i]['distance']." miles<br>Time: ".$groupfeed[$i]['runtime']."<br>Pace: ".$groupfeed[$i]['pace']."<br>Journal: ".$groupfeed[$i]['journal']."</p>";
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
            $groupfeedcomment = $comment;
        
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $groupfeedcomment[$r]['userID'];
                //echo "loop";
                if ($comment[$r]['type'] == 5) {
                    
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
                echo "<p>".$groupfeedcomment[$r]['text']."</p>";
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
        echo "<input type='hidden' value='4' name = 'page' id = 'page'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "<input type='hidden' value='$id' name='pageID' id='pageID'>";
        echo "</form>";
        echo "</div>";// <!-- closes comment -->
        echo "</div>";// <!-- closes commentdiv -->
        echo "</div>"; //closes floater
        echo "</div>";
    } elseif ($posttype == 0 || $posttype == 1 && $permissions < 9 && ($groupinfo['pagepolicy'] == 0 || $permissions >= 1)) {
        
        $strinten;
        if ($posttype == 0) {
            switch ($groupfeed[$i]['intensity']) {
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
            }  //closes switch
        }
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterprofpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        if ($groupfeed[$i]['userID'] == $cid) {
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        } else {
                
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        }
            
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        if ($posttype == 0)
            echo "<div class='profileposts'>";
        elseif ($posttype == 1)
            echo "<div class='speedposts'>";
        echo "<div class='pptext'>";
        
        if ($posttype == 0) 
            echo "<p>Date: ".$groupfeed[$i]['date']."<br>Location: ".$groupfeed[$i]['location']."<br>With: ".$groupfeed[$i]['team']."<br>Distance: ".$groupfeed[$i]['distance']." miles<br>Time: ".$groupfeed[$i]['runtime']."<br>Pace: ".$groupfeed[$i]['pace']." min/mile<br>Intensity: ".$strinten."<br>Notes: ".trim($groupfeed[$i]['journal'])."</p>";
        elseif ($posttype == 1)
            echo "<p>Date: ".$groupfeed[$i]['date']."<br>Location: ".$groupfeed[$i]['location']."<br>With: ".$groupfeed[$i]['team']."<br>Distance: ".$groupfeed[$i]['distance']." miles<br>Description: ".$groupfeed[$i]['description']."<br>Notes: ".trim($groupfeed[$i]['journal'])."</p>";
        
        echo "</div>";
        echo "</div>"; //closes profileposts
        echo "</div>"; //closes floater
        
        
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
            //$comment = $comment;
        
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                if ($comment[$r]['type'] == 5) {
                    
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
            // echo "</div>";
        } //closes if statement
    
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
        echo "<input type='hidden' value='$postID' name = 'postID' id = 'postID'>";
        echo "<input type='hidden' value='$posttype' name = 'ptype' id = 'ptype'>";
        echo "<input type='hidden' value='4' name='page' id='page'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "<input type='hidden' value='$id' name='pageID' id='pageID'>";
        echo "</form>";
        echo "</div>";// <!-- closes comment -->
        echo "</div>";// <!-- closes commentdiv -->
        echo "</div>"; //closes floater
        echo "</div>"; //closes regposts
    } elseif ($groupfeed[$i]['type'] == 9) {
        
            echo "<div class='regposts'>";
            echo "<div class='regpostfloater'>";
            echo "<div class='regposthead'>";
            echo "<div class='postpic'>";
            echo profilepic::getPic(50, $groupinfo['img']);
            echo "</div>"; //closes postpic
            echo "<div class='postname'>";
            echo "<p>".$groupinfo['name']."<br>".$time_elapse[$i]."</p>";
            if ($groupfeed[$i]['userID'] == $cid) {
                //enable user to edit post
                echo "</div>"; //closes postname
                echo "<div class='editpost'>";
                $postid = $groupfeed[$i]['id'];
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
            echo "<p>".$groupfeed[$i]['text']."</p>";
            echo "</div>"; //closes posttext
            echo "</div>"; //closes floater
            //echo "</div>"; //closes regposts
            if ($groupfeed[$i]['img'] != NULL) {
                echo "<div class='regpostfloater'>";
                echo "<div class='regpostpic'>";
                echo profilepic::getPic(460, $groupfeed[$i]['img']);
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
            //echo "loop";
            if ($comment[$r]['type'] == 5) {
                
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
    <input type='hidden' value="<?php echo $groupfeed[$i]['id']; ?>" name = 'postID' id = 'postID'>
    <input type='hidden' value="<?php echo $groupfeed[$i]['type']; ?>" name = 'ptype' id = 'ptype'>
    <input type='hidden' value="<?php echo $groupfeed[$i]['userID']; ?>" name="posterID" id="posterID">
    <input type='hidden' value="4" name="page" id="page">
    <input type='hidden' value='<?php echo $id; ?>' name="pageID" id="pageID">
    </form>
    </div> <!-- close div comment -->
    </div> <!-- closes commentdiv-->
    </div> <!-- closes floater -->
</div>
<?php
    } 
}
unset($groupfeed);
unset($groupinfo);
unset($members);
unset($comment);
unset($like);

    ?>
</div>
</div>
</body>
</html>
