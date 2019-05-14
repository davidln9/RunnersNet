<?php
    include 'msessioncheck.php';
    require '../sendnotification.php';
    
    $anid = isset($_POST['id']) ? $_POST['id'] : null;
    $sendid = intval($anid);
   	$response = array();
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
		$response['message'] = "verify: ".mysqli_error($db);
		$response['error'] = true;
		echo json_encode($response);
		exit;
    }
    
    if ($alreadyadded == 2) {
        $num = 0;
        if ($call = mysqli_query($db, "CALL ChangeStatus('$cid','$sendid','$num')")) {
            //echo 2;
			$response['message'] = "changestatus";
			$response['error'] = false;
			echo json_encode($response);
			exit;
		} else {
            $response['message'] = "ChangeMind: ".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
		}
    }
    if ($alreadyadded == 1) {
        $num = 0;
        if ($call = mysqli_query($db, "CALL ChangeFriendTable('$cid','$sendid','$num')")) {
            //echo 1;
			$response['message'] = "changefriendtable";
			$response['error'] = false;
			echo json_encode($response);
			exit;
		} else {
            $response['message'] = "changemind2: ".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
		}
    }
    if ($alreadyadded == 0) {
        if ($call = mysqli_query($db, "CALL AddFriend('$cid','$sendid')")) {
            
            $action = new SendNotification();
            $notify = $action->notify(-1, 2, -1, $sendid, $db, $cid, 0);
            if (!$notify) {
				$response['message'] = "error notifying";
				$response['error'] = false;
				echo json_encode($response);
				exit;
            } else {
				$response['message'] = "addfriend";
				$response['error'] = false;
				echo json_encode($response);
				exit;
			}
            // echo 0;
            
        } else {
            $response['message'] = "addfriend ".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
		}
    }
    ?>
