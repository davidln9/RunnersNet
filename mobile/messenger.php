<?php
    include 'msessioncheck.php';
    
    if (isset($_POST['btnSubmitText'])) {
		$response = array();
		$temp = ($_POST['receiver']);

		$st = "";
		$parse = false;
		for ($i = 0; $i < strlen($temp); $i++) {
			if ($temp[$i] == "(") {
				$parse = true;
			} else if ($temp[$i] == ")") {
				$parse = false;
			} else if ($parse) {
				$st = $st.$temp[$i];
			}
		}
		$receiver = intval($st);
		$text = mysqli_real_escape_string($db, $_POST['content']);
       	$response['receiver'] = $temp; 
        if ($call = mysqli_query($db, "CALL GetMessageId")) {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            $id = $row['id'] + 1;
            
            
            
            $call->free();
            $db->next_result();
            
        } else {
			$response['message'] = "1".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
		}
        $legal = false;
        date_default_timezone_set('MST');
        $date = date("m/d/Y g:i a");
        if ($call = mysqli_query($db, "CALL GETFRIENDS($cid)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                if ($row['person1'] == $receiver || $row['person2'] == $receiver) {
                    $legal = true;
                }

            }
            $call->free();
            $db->next_result();
        } else {
			$response['message'] = "gf: ".mysqli_error($db);
			$response['error'] = true;
			echo json_encode($response);
			exit;
        }
    //    echo $legal;
        if ($legal) {
            if ($call = mysqli_query($db, "CALL SendMessage('$cid', '$receiver', '$id', '$date', '$text', NULL)")) {
				$response['error'] = false;
				echo json_encode($response);
				exit;
			} else {
                $response['message'] = "line 34 ".mysqli_error($db);
				$response['error'] = true;
				echo json_encode($response);
				exit;
			}
        } else {
            $response['message'] = "not legal";
			$response['error'] = true;
			echo json_encode($response);
            exit;
        }
    }
    
    
    ?>
