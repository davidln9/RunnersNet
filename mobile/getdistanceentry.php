<?php

include 'msessioncheck.php';
   if (isset($_POST['qra'])) {
        
        $public = intval(mysqli_real_escape_string($db, $_POST['public']));
        $length = floatval(mysqli_real_escape_string($db, $_POST['distance']));
        $team = mysqli_real_escape_string($db, $_POST['team']);
        $intensity = intval(mysqli_real_escape_string($db, $_POST['intensity']));
        $runtime = mysqli_real_escape_string($db, $_POST['runtime']);
        $date = mysqli_real_escape_string($db, $_POST['datetime']);
        $avgPace = mysqli_real_escape_string($db, $_POST['avgPace']);
        $type = 0;
        
        $journal=mysqli_real_escape_string($db, $_POST['journal']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        
        $call = mysqli_query($db, "CALL getRunID");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            $id = intval($row['id']) + 1;
            $call->close();
            $db->next_result();
        }
        $shoeID = mysqli_real_escape_string($db, $_POST['shoe']);

		$response = array();
        $call = mysqli_query($db, "CALL setDistance('$type','$cid','$public','$date','$location','$team','$intensity','$journal','$runtime','$avgPace','$id','$length','$shoeID')");
        if (!$call) {
			$response["message"] = mysqli_error($db);
			$response["error"] = true;
			echo json_encode($response);
        } else {
			$response["error"] = false;
			echo json_encode($response);
		}
    }
    ?>
