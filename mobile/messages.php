<?php
    include 'msessioncheck.php';
    include "../elapsedtime.php";
    function mysort($a, $b) {
        
        if ($a == $b)
            return 0;
        elseif ($a['unread'] != 0 || $b['unread'] != 0) 
            return $a['unread'] < $b['unread'];
        return strcasecmp($a['firstname'],$b['firstname']);
    }
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) < strtotime($b['date']);
    }

	$response = array();
	$response['error'] = true;
	if (isset($_POST['user']) && $_POST['user'] == $cid) {

		$messages = array();
		$index = 0;
		if ($call = mysqli_query($db, "CALL GetMessages('$cid')")) {
			while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
				$messages[$index]['sender'] = $row['sender'];
				$messages[$index]['id'] = $row['id'];
				$messages[$index]['date'] = $row['date'];
				$messages[$index]['text'] = $row['text'];
				$messages[$index]['img'] = $row['img_filepath'];
				$messages[$index]['read'] = $row['read'];
				//$messages[$index]['time_elapse'] = elapsedtime::getElapsedTime($row['date']);
				$index++;
			}
			 $call->free();
			 $db->next_result();
		} else {
			$response['message'] = "getmessages: ".mysqli_error($db);
			echo json_encode($response);
			exit;
		}
		usort($messages, "datesort");
		$response['personal_messages'] = $messages;
		//echo "<div class='messagebody'>";
		$response['error'] = false;
		echo json_encode($response);
	}
    //$name = $name;
?>
