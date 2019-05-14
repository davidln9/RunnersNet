<?php
    include 'sessioncheck.php';
    require 'sendnotification.php';
    
    $anid = isset($_GET['id']) ? $_GET['id'] : null;
    $sendid = intval($anid);
    
    $alreadyadded = 0; //0=no request history 1 = they requested you first 2 = you requested them first
    if ($call = mysqli_query($db, "CALL GetFriends('$cid')")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            if ($row['person1'] == $cid) {
                if (intval($row['person2']) == $sendid) {
                    //echo "here";
                    $alreadyadded = 2; //you were the receiver (but are now the sender)
                }
            } else { //you are the sender
                if (intval($row['person1']) == $sendid) {
                    //echo "there";
                    $alreadyadded = 1; //you were the sender (and still are)
                }
            }
        }
        $call->free();
        $db->next_result();
        
    } else {
        echo "verify: ".mysqli_error($db);
    }
    
    if ($alreadyadded == 2) {
        $num = 0;
        if ($call = mysqli_query($db, "CALL ChangeStatus('$cid','$sendid','$num')")) {
            //echo 2;
            header('location: viewprofile.php?id='.$sendid);
        } else {
            echo "ChangeMind: ".mysqli_error($db);
        }
    }
    if ($alreadyadded == 1) {
        $num = 0;
        if ($call = mysqli_query($db, "CALL ChangeFriendTable('$cid','$sendid','$num')")) {
            //echo 1;
            header('location: viewprofile.php?id='.$sendid);
        } else {
            echo "changemind2: ".mysqli_error($db);
        }
    }
    if ($alreadyadded == 0) {
        if ($call = mysqli_query($db, "CALL AddFriend('$cid','$sendid')")) {
            
            $action = new SendNotification();
            $notify = $action->notify(-1, 2, -1, $sendid, $db, $cid, 0);
            if (!$notify) {
                echo "error notifying";
            } else {
                header('location: viewprofile.php?id='.$sendid);
            }
            // echo 0;
            
        } else {
            echo "addfriend ".mysqli_error($db);
        }
    }
    ?>
