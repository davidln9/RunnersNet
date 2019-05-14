<?php
require 'sessioncheck.php';

$type = (isset($_GET['type'])) ? $_GET['type'] : null;
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
$person1 = (isset($_GET['person1'])) ? $_GET['person1'] : null;
$nid = (isset($_GET['nid'])) ? $_GET['nid'] : null;
$group = isset($_GET['group']) ? $_GET['group'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : null;
$uID = isset($_GET['uid']) ? $_GET['uid'] : 0;
$legal = false;

// echo $type." ".$id." ".$person1." ".$nid." ".$group." ".$page." ".$uID;
if ($group == "undefined") {
    $group = 0;
}
// echo $type." ".$id." ".$person1." ".$nid." ".$group." ".$page;
// exit;
if ($page == 1) {
    $uID = $cid;
    if ($call = mysqli_query($db, "CALL GETFRIENDS($cid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            if ($person1 == $row['person1'] || $person1 == $row['person2']) {
                $legal = true;
            }
        }
        $call->free();
        $db->next_result();
    }
    if ($call = mysqli_query($db, "CALL GETMYGROUPS($cid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            if ($row['groupID'] == $person1)
                $legal = true;
        }
        $call->free();
        $db->next_result();
    }
} elseif ($page == 2) {
    
    if ($call = mysqli_query($db, "CALL GETMYGROUPS($cid)")) {
        
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            
            if ($row['groupID'] == $uID && ($row['permissions'] == 3 || $row['permissions'] == 2)) {
                // echo "hi";
//                 exit;
                $legal = true;
            }
        }
        $call->free();
        $db->next_result();
    }
}
if ($legal) {
    // echo $type." ".$nid." ".$id." ".$person1." ".$uID." ".$group;
    // exit;
    if ($call = mysqli_query($db, "CALL REMOVENOTIFICATION($type, $nid, $id, $person1, $uID, $group)")) {

        switch ($page) {
            case 1:
            header("location: notifications.php");
            break;
            case 2:
            header("location: groupnotifications.php?id=$uID");
            break;
            default:
            header("location: profilepage.php");
            break;
        }
    } else {
        echo "1. ".mysqli_error($db);
        exit;
    }
} else {
    echo "Error: not authorized";
}

?>