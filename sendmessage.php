<?php
include 'sessioncheck.php';
include_once "profilepic.php";
function datesort($a, $b) {
    if ($a == $b)
        return 0;
    return strtotime($a['date']) < strtotime($b['date']);
}
include 'elapsedtime.php';
?>
<!DOCTYPE html>
<html>
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
    
        $id = isset($_GET['id']) ? $_GET['id'] : null;
    
        $firstname;
        $lastname;
        $pic;
    
        //get the basic information from this user
        if ($call = mysqli_query($db, "CALL getBasicInfo('$id')")) {
            if ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $pic = $row['img_filepath'];
            }
            $call->free();
            $db->next_result();
        }
    
        
        $message = array();
        $index = 0;
    
    
        //get messages exchanged by the two users
        if ($call = mysqli_query($db, "CALL GetConversation($cid, $id)")) {
        
            while ($row)
        
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                if ($row['receiver'] == $cid) { //handle a received message
                
                
                    $message[$index]['receiving'] = 1;
                    $message[$index]['text'] = $row['text'];
                    $message[$index]['date'] = $row['date'];
                    $message[$index]['img'] = $row['img_filepath'];
                    $message[$index]['read'] = $row['read'];
                    $message[$index]['id'] = $row['id'];
                } elseif ($row['sender'] == $cid) {
                    $message[$index]['receiving'] = 0;
                    $message[$index]['text'] = $row['text'];
                    $message[$index]['date'] = $row['date'];
                    $message[$index]['img'] = $row['img_filepath'];
                    $message[$index]['read'] = $row['read'];
                    $message[$index]['id'] = $row['id'];
                }
            
                
                $index++;            
            }
            $call->free();
            $db->next_result();
        
        } else {
            echo "1".mysqli_error($db);
        }   
        ?>
        <div class='messagehead'>
            <div class='regpostfloater'>
                <div class="opentext">
                    <form id="textform" name="textform" method="post" action="messenger.php" enctype="multipart/form-data">
                        <textarea id="content" rows="3" cols = "50" name="content" placeholder='Send <?php echo $firstname." ".$lastname; ?> a message'></textarea>
                        <div class="postbuttons">
                            <!-- <input type="file" aria-label="Picture/" name="fileToUpload" id="fileToUpload"> -->
                            <input type='hidden' name='receiver' id='receiver' value='<?php echo $id; ?>'>
                            <input type="submit" name="btnSubmitText" id="btnSubmitText" value="Send">
            
                        </div>
                    </form>
                    <?php
                    echo "<button id='btnClearHistory' name='btnClearHistory' value='Delete Conversation' onclick='clearConversation($id)'>Delete Conversation</button>";
                    ?>
                </div>
            </div>
            
        </div> <!-- closes floater -->
    </div> <!-- closes messagehead -->
    
    <?php
    //order the conversation
    usort($message, "datesort");
    
    //display conversation
    echo "<div class='conversationstream'>";
    for ($i = 0; $i < $index; $i++) {
        $thedate = $message[$i]['date'];
        $timeElapsed = elapsedtime::getElapsedTime($thedate);
        if ($message[$i]['receiving'] == 1 && $message[$i]['read'] == 0) { //receiving this message
     
            echo "<div class='message'>";  // MESSAGE
            echo "<div class='regpostfloater'>"; //FLOATER
            echo "<div class='unreadmessages'>"; //READMESSAGES
            echo "<div class='prevcommentrow'>";
            echo "<div class='commenterpic'"; //COMMENTERPIC
            echo "<div class='postpic'>"; //POSTPIC
            echo profilepic::getPic(50, $pic);
            echo "</div>"; //closes postpic
            //echo "</div>"; //closes commenterpic

            echo "<div class='commentername'>";
            echo "<p><a href='viewprofile.php?id=$id'>".$firstname." ".$lastname."</a><br>".$timeElapsed;
            echo "</div>"; //close postname
            echo "</div>";
            //echo "<div class='prevcommentfloater'>";
            echo "<div class='commenttext'>";
            echo "<p>".$message[$i]['text']."</p>";
            // echo "</div>"; //closes messagetext
            echo "</div>"; //closes prevcommentfloater
            echo "</div>"; //closes postnmame
            echo "</div>"; //closes floater
            echo "</div>"; //closes message

            $messID = $message[$i]['id'];
            if (!($call = mysqli_query($db, "CALL SETMESSAGESTATUS($messID, 1)"))) {
                echo myqli_error($db);
            }
        } elseif ($message[$i]['receiving'] == 1 && $message[$i]['read'] != 6 && $message[$i]['read'] != 7) {
                
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
            echo "<p><a href='viewprofile.php?id=$id'>".$firstname." ".$lastname."</a><br>".$timeElapsed."</p>";
            echo "</div>"; //close postname
            echo "</div>";
            //echo "<div class='prevcommentfloater'>";
            echo "<div class='commenttext'>";
            echo "<p>".$message[$i]['text']."</p>";
            // echo "</div>"; //closes messagetext
            echo "</div>"; //closes prevcommentfloater
            echo "</div>"; //closes postnmame
            echo "</div>"; //closes floater
            echo "</div>"; //closes message
        } elseif ($message[$i]['receiving'] == 0 && $message[$i]['read'] != 5 && $message[$i]['read'] != 7) {
            echo "<div class='message'>";  // MESSAGE
            echo "<div class='regpostfloater'>"; //FLOATER
            echo "<div class='readmessages'>"; //READMESSAGES
            echo "<div class='prevcommentrow'>";
            echo "<div class='commenterpic'"; //COMMENTERPIC
            echo "<div class='postpic'>"; //POSTPIC
            echo profilepic::getProfilePic(50);
            echo "</div>"; //closes postpic
            //echo "</div>"; //closes commenterpic

            echo "<div class='commentername'>";
            echo "<p><a href='profilepage.php'>".$_SESSION['fname']." ".$_SESSION['lname']."</a><br>".$timeElapsed."</p>";
            echo "</div>"; //close postname
            echo "</div>";
            //echo "<div class='prevcommentfloater'>";
            echo "<div class='commenttext'>";
            echo "<p>".$message[$i]['text']."</p>";
            // echo "</div>"; //closes messagetext
            echo "</div>"; //closes prevcommentfloater
            echo "</div>"; //closes postnmame
            echo "</div>"; //closes floater
            echo "</div>"; //closes message
        }
    }
    ?>
    <script>
        function clearConversation(userid) {
            window.location.href="conversation.php?action=" + 2 + "&userid=" + userid;
        }
        </script>
    </body>
    </html>
