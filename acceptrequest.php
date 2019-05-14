<?php
    require 'sessioncheck.php';
    include 'sendnotification.php';
    
    $newfriend = isset($_GET['id']) ? $_GET['id'] : null;
    $page = isset($_GET['page']) ? $_GET['page'] : null;
    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $group = isset($_GET['group']) ? $_GET['group'] : 0;
    $sender = isset($_GET['sender']) ? $_GET['sender'] : null;
    
    // echo $newfriend." ".$page." ".$type." ".$group." ".$sender;
 //    exit;
 
    if ($type == 0) {
        if ($call = mysqli_query($db, "CALL AcceptRequest('$newfriend','$cid')")) {
            // echo $newfriend;
            //echo $page;
            // echo $temp3;
            // echo "here";
            // exit;
        
            //  $db->next_result();
            if (!($call = mysqli_query($db, "CALL REMOVENOTIFICATION(-1, 2, -1, $newfriend, $cid, 0)"))) {
                echo "rm Error: ".mysqli_error($db);
                exit;
            }
        
            $action = new SendNotification();
            $send = $action->notify(-1,3,-1,$newfriend, $db, $cid, 0);
        
            unset($action);
        
            if (!($send)) {
                echo "error sending notification";
                exit;
            } 
        
        
            switch ($page) {
                case 0:
                    header('location: notifications.php');
                    //echo "notifications0";
                    break;
                case 1:
                    header('location: viewprofile.php?id='.$newfriend);
                    //echo "viewprofile1";
                    break;
                default:
                    header('location: viewprofile.php?id='.$newfriend);
                    //echo "viewprofiledefault";
                    break;
            }
        } else {
            echo "acceptrequest: ".mysqli_error($db);
        }
    } elseif ($type == 1) {
        if ($call = mysqli_query($db, "CALL ACCEPTGROUPINVITATION($cid, $group, 0)")) {
            if (!($call = mysqli_query($db, "CALL REMOVEGROUPNOTIFICATION($cid, $group)"))) {
                echo "RMGROUPNOTIF: ".mysqli_error($db);
            } else {
                $action = new SendNotification();
                $action->notify(-1, 9, -1, $sender, $db, $cid, $group);
                unset($action);
                
                switch ($page) {
                    case 0:
                    header('location: notifications.php');
                    break;
                    case 1:
                    header('location: viewgroup.php?id='.$group);
                    break;
                    case2:
                    default:
                    header('location: notifications.php');
                    break;
                }
            }
        } 
    } elseif ($type == 2) {
        echo "hi";
        if ($call = mysqli_query($db, "CALL JOINOPENGROUP($cid, $group)")) {
            header("location: viewgroup.php?id=$group");
        } else {
            echo mysqli_error($db);
        }
    }
    ?>
