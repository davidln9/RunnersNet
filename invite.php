<?php
include 'sessioncheck.php';
include 'sendnotification.php';

$type = isset($_POST['type']) ? $_POST['type'] : null;
$friend = isset($_POST['friend']) ? $_POST['friend'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : 9;
$success = false;
if ($action == 0) {
    if ($call = mysqli_query($db, "CALL SENDINVITATION($friend, $cid, $type, $id)")) {
        $success = true;
    } else {
        echo "sendinvitation: ".mysqli_error($db);
    }
    // $call->free();
//     $db->next_result();
    if ($success) {
        $action = new SendNotification();
        if ($type == 0) {
            $action->notify(-1, 4, -1, $friend, $db, $cid, $id);
            unset($action);
            echo "Uninvite";
        } elseif ($type == 2) {
            $action->notify(-1, 11, -1, $friend, $db, $cid, $id);
            unset($action);
            echo "Undo Appoint";
        }
    } else {
        echo "error3";
    }
} elseif ($action == 1) {
    
    if ($call = mysqli_query($db, "CALL UNSENDINVITATION($friend, $cid, $type, $id)")) {
        $success = true;
    }
    // $call->free();
//     $db->next_result();
    if ($success) {
        $action = new SendNotification();
        if ($type == 0) {
            $action->unNotify(-1, 4, -1, $friend, $db, $cid, $id);
            unset($action);
            echo "Invite";
        } elseif ($type == 2) {
            $action->unNotify(-1, 11, -1, $friend, $db, $cid, $id);
            unset($action);
            echo "Appoint";
        }
    } else {
        echo "error4";
    }
}
?>