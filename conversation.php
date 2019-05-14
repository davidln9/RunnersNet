<?php
include 'sessioncheck.php';
$action = (isset($_GET['action'])) ? $_GET['action'] : null ;
$userID = isset($_GET['userid']) ? $_GET['userid'] : null;

if ($action == 2) { //clear the conversation
    $conversation = array();
    $cindex = 0;
    if ($call = mysqli_query($db, "CALL GETCONVERSATION($cid, $userID)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            
            $conversation[$cindex]['sender'] = $row['sender'];
            $conversation[$cindex]['receiver'] = $row['receiver'];
            $conversation[$cindex]['read'] = $row['read'];
            $conversation[$cindex]['id'] = $row['id'];
            $cindex++;
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getconversation: ".mysqli_error($db);
    }
    
    for ($i = 0; $i < $cindex; $i++) {
        $mid = $conversation[$i]['id'];
        
        if ($conversation[$i]['sender'] == $cid && $conversation[$i]['read'] != 6 && $conversation[$i]['read'] != 7) {
            if (!($call = mysqli_query($db, "CALL SETMESSAGESTATUS($mid, 5)"))) { //deleted by the sender, but not the receiver
                echo "'sender' == cid: ".mysqli_error($db);
            }
        } elseif ($conversation[$i]['sender'] == $cid && $conversation[$i]['read'] == 6) {
            if (!($call = mysqli_query($db, "CALL SETMESSAGESTATUS($mid, 7)"))) { //deleted by both
                echo "'receiver' == cid: ".mysqli_error($db);
            }
        } elseif ($conversation[$i]['read'] != 5 && $conversation[$i]['read'] != 7) {
            if (!($call = mysqli_query($db, "CALL SETMESSAGESTATUS($mid, 6)"))) { //deleted by the receiver, but not by the sender
                echo "35. ".mysqli_error($db);
            }
        } elseif ($conversation[$i]['read'] == 5) {
            if (!($call = mysqli_query($db, "CALL SETMESSAGESTATUS($mid, 7)"))) { //delete by both
                echo "39. ".mysqli_error($db);
            }
        }
    }
}
header("location: sendmessage.php?id=$userID");
?>