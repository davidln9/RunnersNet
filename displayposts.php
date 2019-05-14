<?php
class DisplayPosts {
    
    public static function displayRaces($posterprofpic, $pfirstname, $plastname, $i, $store, $basic, $time_elapse, $userLike, $postID, $posttype, $poster, $comm, $comment, $call, $db, $cid, $cind, $basicinfo, $comstmt, $likestmt, $groupstmt) {
        //echo "<br>A race goes here<br>";
        
        include_once 'profilepicture.php';
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
            $basicinfo->bind_param("i", $commenter_id); 
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                
                
                // $basicinfo->bind_param("i", $commenter_id);
//                 $basicinfo->execute();
//                 $result = $basicinfo->get_result();
//                 while ($row = $result->fetch_assoc()) {
//                     $comment[$r]['firstname'] = $row['firstname'];
//                     $comment[$r]['lastname'] = $row['lastname'];
//                     $comment[$r]['img'] = $row['img_filepath'];
//                 }
//                 $db->next_result();
                if ($comment[$r]['type'] == 5) {
    
                    //$basicinfo->bind_param("i", $commenter_id);
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
        echo "<input type='hidden' value='$cid' name='commenter' id='commenter'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "</form>";
        echo "</div>";// <!-- closes comment -->
        echo "</div>";// <!-- closes commentdiv -->
        echo "</div>"; //closes floater
        echo "</div>";
    }
    
    public static function displayRegPosts($sorted, $i, $userLike, $posterprofpic, $pfirstname, $plastname, $time_elapse, $poster, $type, $postID, $comm, $comment, $cind, $likeIndex, $basicinfo, $comstmt, $likestmt, $db, $cid) {
        
        
        include_once 'profilepicture.php';
        
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterprofpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        if ($poster == $cid) {
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        } else {
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        }
        if ($poster == $cid) {
            echo "</div>"; //closes postname
            echo "<div class='editpost'>";
            $query = array('id' => $cid, 'type' => 3, 'postid' => $postID);
            $query = http_build_query($query);
            echo "<a href='editpost.php?$query'>Edit</a>";
            echo "</div>"; //closes editpost
        } else {
            echo "</div>"; //closes postname
        }
        echo "</div>"; //closes posthead
        echo "</div>"; //floater
        echo "<div class='regpostfloater'>";
        echo "<div class='posttext'>";
        echo "<p>".$sorted[$i]['text']."</p>";
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
        if ($sorted[$i]['img'] != NULL) {
            echo "<div class='regpostfloater'>";
            echo "<div class='regpostpic'>";
            echo profilepic::getPic(460, $sorted[$i]['img']);
                
            echo "</div>"; //closes floater
            echo "</div>"; //closes regpost
        }


        
            
        
            if ($userLike == true) {
    
                echo "<div class='likepostfloater'>";
                echo "<div class='likeable'>";
                // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
                //$query = http_build_query($query);
                //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
                echo "<button id='unlikeButton$i' onclick='unlikePost($type,$postID,$poster,$i)'>Liked</button>";
                echo "</div>"; //closes likeable
                echo "</div>"; //closes floater
    
            } else {
                echo "<div class='likepostfloater'>";
                echo "<div class='likeable'>";
                // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
            //     //$query = http_build_query($query);
                //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
                echo "<button id='likeButton$i' onclick='likePost($postID,$type,$poster,$i)'>Like</button>";
                echo "</div>"; //closes likeable
                echo "</div>"; //closes floater
            }
    


        if ($comm == true) {
            echo "<div class='regpostfloater'>";
            echo "<div class = 'prevcomments'>";
            echo "<div class = 'prevcommentsdiv'>";
            // $comment = $comment;
            $basicinfo->bind_param("i", $commenter_id);
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                
                //$basicinfo->bind_param("i", $commenter_id);
                $basicinfo->execute();
                $result = $basicinfo->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $comment[$r]['firstname'] = $row['firstname'];
                    $comment[$r]['lastname'] = $row['lastname'];
                    $comment[$r]['img'] = $row['img_filepath'];
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
        
            } //closes for loop
            echo "</div>"; //closes div 'prevcomments'
            echo "</div>"; //closes div 'regpost'
    
            echo "</div>"; //closes floater
        }
        
    
        echo "<div class = 'regpostfloater'>";
        echo "<div class = 'commentdiv'>";
        echo "<div class = 'comment'>";
        echo "<div class = 'commentpic'>";
    
        echo profilepic::getProfilePic(40);
    
    
        echo "</div>"; //closes commentpic
        echo "<form method='post' action='submitcomment.php' name='commentform' id='commentform'>";
        echo "<div class='insertcomment'>";
        echo "<input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30' autocomplete='off'>";
        echo "</div>"; //closes insertcomment
        echo "<input type='hidden' value='$postID' name = 'postID' id = 'postID'>";
        echo "<input type='hidden' value='$type' name = 'ptype' id = 'ptype'>";
        echo "<input type='hidden' value='0' name = 'page' id = 'page'>";
        echo "<input type='hidden' value='$cid' name='commenter' id='commenter'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "</form>";
        echo "</div>";//close div comment 
        echo "</div>";// <!-- closes commentdiv-->
        echo "</div>"; // <!-- closes floater -->
        echo "</div>"; //closes regposts
    }
    
    public static function displayPagePosts($posteefname, $posteelname, $posteepic, $sorted, $i, $userLike, $posterprofpic, $pfirstname, $plastname, $time_elapse, $poster, $postee, $type, $postID, $comm, $comment, $cind, $likeIndex, $basicinfo, $comstmt, $likestmt, $db, $groupstmt, $cid) {
        
        // echo "here";
        
        
        include_once 'profilepicure.php';
        
        // echo "thre";
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterprofpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        // echo $type;
        
        
        if ($poster == $cid && $type == 4) {
            
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a> ––> <a href='viewprofile.php?id=$postee'>".$posteefname." ".$posteelname."</a><br>".$time_elapse[$i]."</p>";
        } elseif ($postee == $cid && $type == 4) {
            
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a> ––> <a href='profilepage.php'>".$posteefname." ".$posteelname."</a><br>".$time_elapse[$i]."</p>";
        } elseif ($type == 4) {
            
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a> ––> <a href='viewprofile.php?id=$postee'>".$posteefname." ".$posteelname."</a><br>".$time_elapse[$i]."</p>";
        } elseif ($poster == $cid) { //and type is 7
            
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a> ––> <a href='viewgroup.php?id=$postee'>".$posteefname."</a><br>".$time_elapse[$i]."</p>";
        } else {
           
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a> ––> <a href='viewgroup.php?id=$postee'>".$posteefname."</a><br>".$time_elapse[$i]."</p>";
        }
        
        
        if ($poster == $cid) { //check if this user posted it
            echo "</div>"; //closes postname
            echo "<div class='editpost'>";
            $query = array('id' => $cid, 'type' => 3, 'postid' => $postID);
            $query = http_build_query($query);
            echo "<a href='editpost.php?$query'>Edit</a>";
            echo "</div>"; //closes editpost
        } else {
            echo "</div>"; //closes postname
        }
        
        echo "</div>"; //closes posthead
        echo "</div>"; //floater
        echo "<div class='regpostfloater'>";
        echo "<div class='posttext'>";
        echo "<p>".$sorted[$i]['text']."</p>";
        echo "</div>"; //closes posttext
        echo "</div>"; //closes floater
     
        if ($sorted[$i]['img'] != NULL) {
            echo "<div class='regpostfloater'>";
            echo "<div class='regpostpic'>";
            echo profilepic::getPic(460, $sorted[$i]['img']);
                
            echo "</div>"; //closes pic
            echo "</div>"; //closes floater
        }
        
        if ($userLike == true) {
    
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
            //$query = http_build_query($query);
            //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
            echo "<button id='unlikeButton$i' onclick='unlikePost($type,$postID,$poster,$i)'>Liked</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
    
        } else {
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
        //     //$query = http_build_query($query);
            //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
            echo "<button id='likeButton$i' onclick='likePost($postID,$type,$poster,$i)'>Like</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
        }
        
        
        if ($comm == true) {
            echo "<div class='regpostfloater'>";
            echo "<div class = 'prevcomments'>";
            echo "<div class = 'prevcommentsdiv'>";
            // $comment = $comment;
            for ($r = 0; $r < $cind; $r++) {
                $commenter_id = $comment[$r]['userID'];
                //echo "loop";
                // $basicinfo->bind_param("i", $commenter_id);
//                 $basicinfo->execute();
//                 $result = $basicinfo->get_result();
//
//                 while ($row = $result->fetch_assoc()) {
//                     $comment[$r]['firstname'] = $row['firstname'];
//                     $comment[$r]['lastname'] = $row['lastname'];
//                     $comment[$r]['img'] = $row['img_filepath'];
//                 }
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
        
        echo "<div class = 'regpostfloater'>";
        echo "<div class = 'commentdiv'>";
        echo "<div class = 'comment'>";
        echo "<div class = 'commentpic'>";
    
        echo profilepic::getProfilePic(40);
    
    
        echo "</div>"; //closes commentpic
        echo "<form method='post' action='submitcomment.php' name='commentform' id='commentform'>";
        echo "<div class='insertcomment'>";
        echo "<input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30' autocomplete='off'>";
        echo "</div>"; //closes insertcomment
        echo "<input type='hidden' value='$postID' name = 'postID' id = 'postID'>";
        echo "<input type='hidden' value='$type' name = 'ptype' id = 'ptype'>";
        echo "<input type='hidden' value='0' name = 'page' id = 'page'>";
        echo "<input type='hidden' value='$cid' name='commenter' id='commenter'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "</form>";
        echo "</div>";//close div comment 
        echo "</div>";// <!-- closes commentdiv-->
        echo "</div>"; // <!-- closes floater -->
        
        
        echo "</div>"; //closes regpost
        
        
        
    }
    
    //public static function displayDistanceRuns($sorted, $i, $userLike, $posterprofpic, $pfirstname, $plastname, $time_elapse, $poster, $type, $postID, $comm, $comment, $cind, $basicinfo, $comstmt, $likestmt, $db) {
    public static function displayDistanceRuns($sorted, $i, $userLike, $posterprofpic, $pfirstname, $plastname, $time_elapse, $poster, $type, $postID, $comm, $comment, $cind, $likeIndex, $basicinfo, $comstmt, $likestmt, $db, $cid, $groupstmt) {
        
        include_once 'profilepicture.php';
        $strinten;
        if ($type == 0) {
            switch ($sorted[$i]['intensity']) {
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
        if ($sorted[$i]['userID'] == $cid) {
            echo "<p><a href='profilepage.php'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        } else {
                
            echo "<p><a href='viewprofile.php?id=$poster'>".$pfirstname." ".$plastname."</a><br>".$time_elapse[$i]."</p>";
        }
            
        echo "</div>"; //closes postname
        echo "</div>"; //closes head
        echo "</div>"; //closes floater
        echo "<div class='regpostfloater'>";
        if ($type == 0)
            echo "<div class='profileposts'>";
        elseif ($type == 1)
            echo "<div class='speedposts'>";
        echo "<div class='pptext'>";
        if ($type == 0) {
            echo "<p>Date: ".$sorted[$i]['date']."<br>Location: ".$sorted[$i]['location']."<br>With: ".$sorted[$i]['team']."<br>Distance: ".$sorted[$i]['distance']." miles<br>Time: ".$sorted[$i]['runtime']."<br>Pace: ".$sorted[$i]['pace']." min/mile<br>Intensity: ".$strinten."<br>Notes: ".trim($sorted[$i]['journal'])."</p>";
        } elseif ($type == 1) {
            echo "<p>Date: ".$sorted[$i]['date']."<br>Location: ".$sorted[$i]['location']."<br>With: ".$sorted[$i]['team']."<br>Distance: ".$sorted[$i]['distance']." miles<br>Description: ".$sorted[$i]['description']."<br>Notes: ".trim($sorted[$i]['journal'])."</p>";
        }
        echo "</div>";
        echo "</div>"; //closes profileposts
        echo "</div>"; //closes floater
        
        
        if ($userLike == true) {
    
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("posttype" => $posttype, "postID" => $postID, "page" => 0);
            //$query = http_build_query($query);
            //echo "<a href='unlikepost.php?$query'><font color='grey'>Like</font></a> | <a href='#'>Repost</a>";
            echo "<button id='unlikeButton$i' onclick='unlikePost($type,$postID,$poster,$i)'>Liked</button>";
            echo "</div>"; //closes likeable
            echo "</div>"; //closes floater
    
        } else {
            echo "<div class='likepostfloater'>";
            echo "<div class='likeable'>";
            // $query = array("id" => $postID, "type" => $posttype, "poster" => $poster, "page" => 1);
        //     //$query = http_build_query($query);
            //echo "<a href='likepost.php?$query'>Like</a> | <a href='#'>Repost</a>";
            echo "<button id='likeButton$i' onclick='likePost($postID,$type,$poster,$i)'>Like</button>";
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
        echo "<input type='hidden' value='$type' name = 'ptype' id = 'ptype'>";
        echo "<input type='hidden' value='0' name='page' id='page'>";
        echo "<input type='hidden' value='$cid' name='commenter' id='commenter'>";
        echo "<input type='hidden' value='$poster' name='posterID' id = 'posterID'>";
        echo "</form>";
        echo "</div>";// <!-- closes comment -->
        echo "</div>";// <!-- closes commentdiv -->
        echo "</div>"; //closes floater
        echo "</div>"; //closes regposts
    }
    public static function displayGroupPosts($posterprofpic, $time_elapse, $pfirstname, $groupfeed, $userLike, $postID, $posttype, $poster, $i, $db, $basicinfo, $comment, $groupstmt, $cid, $comm, $cind) {
        
        include_once 'profilepicture.php';
        
        
        echo "<div class='regposts'>";
        echo "<div class='regpostfloater'>";
        echo "<div class='regposthead'>";
        echo "<div class='postpic'>";
        echo profilepic::getPic(50, $posterprofpic);
        echo "</div>"; //closes postpic
        echo "<div class='postname'>";
        echo "<p><a href='viewgroup?id=$poster'>".$pfirstname."</a><br>".$time_elapse[$i]."</p>";
        
        echo "</div>"; //closes postname
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
            
            echo "</div>";// <!--closes postpic-->
            echo "</div>";// <!--closes floater-->


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
    
    
    
    echo "<div class = 'regpostfloater'>";
    echo "<div class = 'commentdiv'>";
    echo "<div class = 'comment'>";
    echo "<div class = 'commentpic'>";
    
    echo profilepic::getProfilePic(40);
    
    echo "</div>";// <!-- closes div commentpic-->
    echo "<form method='post' action='submitcomment.php' name='commentform' id='commentform'>";
    echo "<div class='insertcomment'>";
    echo "<input type='inputtext' placeholder='Add a comment' name='text' id='text' size='30' autocomplete='off'>";
    echo "</div>";// <!-- close div insertcomment -->
    echo "<input type='hidden' value='$postID' name = 'postID' id = 'postID'>";
    echo "<input type='hidden' value='$posttype' name = 'ptype' id = 'ptype'>";
    echo "<input type='hidden' value='$poster' name='posterID' id='posterID'>";
    echo "<input type='hidden' value='0' name='page' id='page'>";
    echo "<input type='hidden' value='$poster' name='pageID' id='pageID'>";
    echo "</form>";
    echo "</div>";// <!-- close div comment -->
    echo "</div>";// <!-- closes commentdiv-->
    echo "</div>";// <!-- closes floater -->
    echo "</div>";
    }
}

        ?>
