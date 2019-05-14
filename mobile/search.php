<?php
    include 'msessioncheck.php';
    
    function mysort($a, $b) {
        if ($a == $b)
            return 0;
        elseif ($a['type'] == $b['type'])
            return strcasecmp($a, $b);
        else
            return $a['type'] > $b['type'];
	}
	function sortByMatch($a, $b) {
		if ($a == $b)
			return 0;
		else if ($a['match'] == $b['match'])
			return $a['type'] > $b['type'];
		else
			return $a['match'] > $b['match'];
	}	
    
    if (isset($_POST['msearch'])) {
        $search = $_POST['search'];
		$response = array(); 
		$response['people'] = false;
		$response['match'] = false;
		$response['fresult'] = false;
		$names = array();
        $info = array();
        $index = 0;
        if ($call=mysqli_query($db, "CALL GETPEOPLE")) {
            while ($row=mysqli_fetch_array($call, MYSQLI_BOTH)) {
             	$response['people'] = true;   
                $info[$index]['type'] = 1; //1 is for person, 2 is for group
                $info[$index]['fname'] = $row['firstname'];
                $info[$index]['lname'] = $row['lastname'];
                $info[$index]['id'] = $row['cryptID'];
                $info[$index]['img'] = $row['img_filepath'];
				$info[$index]['runnertype'] = $row['runnertype'];
				$info[$index]['birthdate'] = $row['birthdate'];
				$info[$index]['city'] = $row['city'];
				$info[$index]['state'] = $row['state'];
				$info[$index]['gender'] = $row['gender'];
				$info[$index]['bio'] = $row['biography'];
				$index++;
			}

            $call->free();
            $db->next_result();
        } else {
            $message['message'] = "getpeople: ".mysqli_error($db);
			$message['error'] = true;
			echo json_encode($message);
			exit;
		}
        
		$result = 0;
		$people = false;
		$groups = false;
		$results = array();
		//picture first name last name search results
		
		for ($i=0; $i<$index; $i++) {
			//if ($info[$i]['type'] == 1) {
				similar_text(strtolower($info[$i]['fname']), strtolower($search), $fnameonly);
				similar_text(strtolower($info[$i]['lname']), strtolower($search), $lnameonly);
				similar_text(strtolower($info[$i]['fname'] + " " + $info[$i]['lname']), strtolower($search), $fandlname);

				if ($fnameonly >= 70  || $lnameonly >= 70 || $fandlname >= 60) {
					$response['match'] = true;
					$id = $info[$i]['id'];
					$call = $db->prepare("CALL GetAllFriends(?)");
					$call->bind_param("i", $id);
					$call->execute();
					$res = $call->get_result();
					$friends = array();
					$findex = 0;
					while ($row = $res->fetch_assoc()) {
						if (intval($row['person1']) != intval($id)) {
							$friends[$findex]['id'] = $row['person1'];
							$friends[$findex]['sender'] = false;
						} else {
							$friends[$findex]['id'] = $row['person2'];
							$friends[$findex]['sender'] = true;
						}
			            $friends[$findex]['status'] = $row['status'];
			            $findex++;
					}
					$db->next_result();
					$myfriend = -1;
					$sender = false;
					$some = array();
					for ($f = 0; $f < $findex; $f++) {
						if (intval($friends[$f]['id']) == intval($cid)) {
							$myfriend = intval($friends[$f]['status']);
					        $sender = $friends[$f]['sender'];
							$response['fresult'] = true;
							$response['fstatus'] = $friends[$f]['status'];
						}
					}
					$info[$i]['sender'] = $sender;
					$info[$i]['friendtype'] = $myfriend;
					if ($fnameonly >= $lnameonly && $fnameonly >= $fandlname) {
						$info[$i]['match'] = $fnameonly;
					} else if ($lnameonly >= $fnameonly && $lnameonly >= $fandlname) {
						$info[$i]['match'] = $lnameonly;
					} else if ($fandlname >= $fnameonly && $fandlname >= $lnameonly) {
						$info[$i]['match'] = $fandlname;
					}
					
					$results[$result] = $info[$i];
					$result++;
					$people = true;
				}
			//} elseif ($info[$i]['type'] == 2) {
			//	if (strcasecmp($search,$info[$i]['name']) == 0) {
			//		$results[$result] = $info[$i];
			//		$result++;
			//		$groups = true;
			//	}
			//}
		}
		
		usort($results, "sortByMatch");
		$response['results'] = $results;
		$response['error'] = false;
		echo json_encode($response);
		unset($results);
	}
?>

