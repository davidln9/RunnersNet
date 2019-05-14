<?php
include 'sessioncheck.php';
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$user = (isset($_GET['user'])) ? $_GET['user'] : null;

echo $action." ".$user;
$sendval = -3;
$order;

if ($call = mysqli_query($db, "CALL GETALLFRIENDS($cid)")) {


    while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
        if ($row['person1'] == $user) {
            $sendval = 5;
            $order = 2;
            echo "here";
        } else if ($row['person2'] == $user) {
            $sendval = 4;
            $order = 1;
            echo "there";
        }
    }
    $call->free();
    $db->next_result();
} else {
    echo "line 10".mysqli_error($db);
    exit;
}

if ($action == 1) {
    
    
    //they friended me
    if ($order == 2) {
        if (!($call = mysqli_query($db, "CALL REMOVEFRIEND($user, $cid, $sendval)"))) {
            echo "line 29".mysqli_error($db);
            exit;
        }
    } else if ($order == 1) { //I friended them
        
        if (!($call = mysqli_query($db, "CALL REMOVEFRIEND($cid, $user, $sendval)"))) {
            echo "line 33".mysqli_error($db);
            exit;
        }
    }

} elseif ($action == 2) {
    if ($order == 1) { //order determines where to put the parameters.
        if (!($call = mysqli_query($db, "CALL UNDODENYFRIENDREQUEST($cid, $user)"))) {
            echo "line 44 ".mysqli_error($db);
            exit;
        }
    } elseif ($order == 2) {
        if (!($call = mysqli_query($db, "CALL UNDODENYFRIENDREQUEST($user, $cid)"))) {
            echo "line 48 ".mysqli_error($db);
            exit;
        }
    } else {
        echo $order;
    }
    // echo $order;
}
?>