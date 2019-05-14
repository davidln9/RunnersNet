<?php
	include 'msessioncheck.php';
	include '../elapsedtime.php';
	$response = array();
	$index = 0;
	$messages = array();

	if (isset($_POST['bbjd'])) {
		if ($call = mysqli_query($db, "CALL GetMessages('$cid')")) {
			while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
    			$messages[$index]['sender'] = $row['sender'];
        		$messages[$index]['id'] = $row['id'];
			   	$messages[$index]['date'] = strtotime($row['date']);
			   	$messages[$index]['text'] = $row['text'];
			   	$messages[$index]['img'] = $row['img_filepath'];
			   	$messages[$index]['status'] = $row['read'];
				//$messages[$index]['time_elapse'] = elapsedtime::getElapsedTime($row['date']);																		
				$index++;
	 		}
	    	$call->free();
	    	$db->next_result();
		} else {
			$response['message'] = "getunreadmessages: ".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
		}
		$requests = 0;
		$notifs = 0;
		$notifications = array();
		// echo $cid;
		if ($call = mysqli_query($db, "CALL GETNOTIFICATIONS($cid)")) {
			// echo "here";
			while ($row = mysqli_fetch_assoc($call)) {
				// echo "there";
				if ($row['status'] != 3) {
					$notifications[$notifs]['posttype'] = $row['posttype'];
					$notifications[$notifs]['notifType'] = $row['notifType'];
					$notifications[$notifs]['postID'] = $row['postID'];
					$notifications[$notifs]['notifier'] = $row['notifier'];
					$notifications[$notifs]['date'] = $row['date'];
					$notifications[$notifs]['status'] = $row['status'];
					$notifications[$notifs]['group'] = $row['gID'];
					
					$notifs++;
				}
			}
			$call->free();
			$db->next_result();
			// echo $notifs;
		} else {
			$response['error'] = true;
			$response['message'] = "getnotifications: ".mysqli_error($db);
			echo json_encode($response);
			exit;
		}

		for ($g = 0; $g < $notifs; $g++) {
			$call = $db->prepare("CALL GETBASICINFO(?)");
			$call->bind_param("i", $nid);
			$nid = $notifications[$g]['notifier'];
			$call->execute();
			$result = $call->get_result();

			while ($row = $result->fetch_assoc()) {
				$notifications[$g]['img_filepath'] = $row['img_filepath'];
				$notifications[$g]['firstname'] = $row['firstname'];
				$notifications[$g]['lastname'] = $row['lastname'];
				$notifications[$g]['biography'] = $row['biography'];
				$notifications[$g]['city'] = $row['city'];
				$notifications[$g]['state'] = $row['state'];
				$notifications[$g]['bdate'] = $row['birthdate'];
			}
			$db->next_result();
		}
		$response['error'] = false;
		$response['messages'] = $messages;
		$response['notifications'] = $notifications;
		echo json_encode($response);
		exit;
		}
	$response['error'] = true;
	$response['message'] = "outside";
	echo json_encode($response);
?>
