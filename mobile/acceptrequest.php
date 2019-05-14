<?php
    require 'msessioncheck.php';
    include '../sendnotification.php';
    
    $newfriend = isset($_POST['id']) ? $_POST['id'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $group = isset($_POST['group']) ? $_POST['group'] : 0;
    $sender = isset($_POST['sender']) ? $_POST['sender'] : null;
    
    // echo $newfriend." ".$page." ".$type." ".$group." ".$sender;
 //    exit;

	$response = array();	
    if ($type == 0) {
        if ($call = mysqli_query($db, "CALL AcceptRequest('$newfriend','$cid')")) {
            // echo $newfriend;
            //echo $page;
            // echo $temp3;
            // echo "here";
            // exit;
        
            //  $db->next_result();
            if (!($call = mysqli_query($db, "CALL REMOVENOTIFICATION(-1, 2, -1, $newfriend, $cid, 0)"))) {
                $response['message'] = "rm Error: ".mysqli_error($db);
				$response['error'] = false;
				echo json_encode($response);
				exit;
            }
        
            $action = new SendNotification();
            $send = $action->notify(-1,3,-1,$newfriend, $db, $cid, 0);
        
            unset($action);
        
            if (!($send)) {
               	$response['message'] "error sending notification";
				$response['error'] = false;
				echo json_encode($response);
				exit;
            } 
        
        
   			$response['error'] = false;
		   	$response['message'] = "acceptrequest && removenotification";
			echo json_encode($response);
			exit;	
        } else {
			$response['message'] = "acceptrequest: ".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
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
