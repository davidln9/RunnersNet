<?php
    include "sessioncheck.php";
    if(isset($_POST)) {
        $posttype = intval($_POST['ptype']);
        $type = 5;
        $pid = intval($_POST['postID']);
        $onpage = $_SESSION['postee'];
        // date_default
        date_default_timezone_set("MST");
        $date = date("m/d/Y g:i a");
        $txt = $_POST['text'];
        $text = mysqli_real_escape_string($db, $txt);
        
        $commid;
        if ($call = mysqli_query($db, "CALL GetCommentID")) {
            $row = mysqli_fetch_array($call, MYSQLI_NUM);
            $commid = intval($row[0] + 1);
            $call->free();
            $db->next_result();
            //            echo "comid=".$commid;
            //            echo "Post type: ".$posttype;
            //            echo "Post ID: ".$pid;
        }
        if ($call = mysqli_query($db, "CALL InsertComment('$type','$posttype','$pid','$commid','$date','$cid','$text',NULL)")) {
            
            header("location: viewprofile.php?id=$onpage");
        } else {
            echo mysqli_error($db);
        }
        
    }
    ?>
