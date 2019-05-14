<?php
    include 'msessioncheck.php';
    
	if (isset($_POST['gabm'])) {
		$response['error'] = true;
		$bio = mysqli_real_escape_string($db, $_POST['thebio']);
		$call = mysqli_query($db, "CALL ChangeBio('$cid','$bio')");
		if (!$call) {
			$response['message'] = mysqli_error($db);
			echo json_encode($response);
		} else {
			$response['error'] = false;
			echo json_encode($response);
		}
	}
?>
