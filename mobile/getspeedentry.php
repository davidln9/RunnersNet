<?php
    include 'msessioncheck.php';
    
   if (isset($_POST['ggd'])) {
        
        $public = intval(mysqli_real_escape_string($db, $_POST['public'])); //
        $warmup = floatval(mysqli_real_escape_string($db, $_POST['warmup'])); //
        $workout = floatval(mysqli_real_escape_string($db, $_POST['workout']));
        $cooldown = floatval(mysqli_real_escape_string($db, $_POST['cooldown']));
        $datetime = mysqli_real_escape_string($db, $_POST['datetime']); //
        $team = mysqli_real_escape_string($_POST['team']); //
        $description = mysqli_real_escape_string($db, $_POST['description']); //
        $journal = mysqli_real_escape_string($db, $_POST['journal']); //
        
        $length = $warmup + $workout + $cooldown;

        //$datetime = $date." ".$time;
        //$journal=mysqli_real_escape_string($db, $_POST['txtJournal']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        $id;
        $call = mysqli_query($db, "CALL GETSPEEDID");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            $id = intval($row['id']) + 1;
            $call->free();
            $db->next_result();
        }
        $response = array();
        if (!($call = mysqli_query($db, "CALL INSERTSPEEDWORKOUT($id, $cid, '$location', '$datetime', '$description', $length, '$team', '$journal', $public, $warmup, $cooldown, $workout)"))) {
			$response["error"] = true;
			$response["message"] = mysqli_error($db);
			echo json_encode($response);
        } else {
			$response["error"] = false;
			echo json_encode($response);
		}
        
    }
    ?>
