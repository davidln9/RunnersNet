<?php
require('msessioncheck.php');

$response = array();
$message = array();
$index = 0;

if (isset($_POST['id'])) {
	$id = $_POST['id'];
	if ($call = mysqli_query($db, "CALL GetConversation($cid, $id)")) {
		while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
			if ($row['receiver'] == $cid) {
				$message[$index]['receiving'] = "1";
				$message[$index]['text'] = $row['text'];
				$message[$index]['date'] = strtotime($row['date']);
				$message[$index]['img'] = $row['img_filepath'];
				$message[$index]['read'] = $row['read'];
				$message[$index]['id'] = $row['id'];
			} elseif ($row['sender'] == $cid) {
				$message[$index]['receiving'] = "0";
				$message[$index]['text'] = $row['text'];
				$message[$index]['date'] = strtotime($row['date']);
				$message[$index]['img'] = $row['img_filepath'];
				$message[$index]['read'] = $row['read'];
				$message[$index]['id'] = $row['id'];
			}

			$index++;
		}
		
		$response['error'] = false;
		$response['message'] = $message;
		echo json_encode($response);

		$call->free();
		$db->next_result();
	} else {
		$response['error'] = true;
		$response['message'] = mysqli_error($db);
		echo json_encode($response);
	}
	exit;
}

$response['error'] = true;
$response['message'] = "id not set";
echo json_encode($response);
