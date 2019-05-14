<?php
// include "sessioncheck.php";

    if( isset($_POST['login']) ) {
        if ($_POST['retpass'] != "" && $_POST['retemail'] != "") {
            loginToServer($_POST['retemail'], $_POST['retpass']);
        } else {
            header('Location: failedlogin.php');
            
        }
    }
    $response = array();
    $uname = $_POST['retemail'];
    $pass = $_POST['retpass'];
    $call;
	include 'secure.php';
	$db = mysqli_connect($server,$user,$password,$database);
    if (!$call = mysqli_query($db, "CALL login('$uname')")) {
        $response['error'] = true;
        $response['message'] = mysqli_error($db);
    } else {
        $rows = mysqli_num_rows($call);
        if ($rows > 0) {
            $pw;
            $cryptID;
            while ($row = mysqli_fetch_array($call)) {
                $pw = $row['password'];
                $cryptID = $row['cryptID'];
            }
            $call->free();
            $db->next_result();
            if (password_verify($pass, $pw)) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['cid'] = $cryptID;                            
                $call = mysqli_query($db, "CALL getBasicInfo('$cryptID')");
                $row = mysqli_fetch_array($call, MYSQLI_BOTH);
                $_SESSION['fname'] = $row['firstname'];
                $_SESSION['lname'] = $row['lastname'];
                $_SESSION['birthdate'] = $row['birthdate'];
                $_SESSION['pnumber'] = $row['pnumber'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['preference'] = $row['runnertype'];
                $_SESSION['city'] = $row['city'];
                $_SESSION['state'] = $row['state'];
                $_SESSION['profilepic'] = $row['img_filepath'];
                $_SESSION['biography'] = $row['biography'];
                $call->free();
                $db->next_result();

				$call = $db->prepare("CALL GETSHOES(?)");
				$call->bind_param("i", $cryptID);
				$call->execute();
				$result = $call->get_result();
				$shoes = array();
				$shoeIndex = 0;
				
				while ($row = $result->fetch_assoc()) {
					$shoes[$shoeIndex]['shoeID'] = $row['shoeID'];
					$shoes[$shoeIndex]['Make'] = $row['Make'];
					$shoes[$shoeIndex]['Model'] = $row['Model'];
					$shoes[$shoeIndex]['year'] = $row['year'];
					$shoeIndex++;
				}
				$response['shoes'] = $shoes;
                $response['error'] = false;
                $response['message'] = "Login Success";
				$response['id'] = $cryptID;
				$response['firstname'] = $_SESSION['fname'];
				$response['lastname'] = $_SESSION['lname'];
				$response['img_filepath'] = $_SESSION['profilepic'];
				$response['biography'] = $_SESSION['biography'];
			
				$response['birthdate'] = $_SESSION['birthdate'];
				$response['city'] = $_SESSION['city'];
				$response['state'] = $_SESSION['state'];
				$response['gender'] = $_SESSION['gender'];
				$response['runnertype'] = $_SESSION['preference'];
			} else {
                $response['error'] = true;
                $response['message'] = "Invalid Password for that Account";
            }
            
        } else {
            $response['error'] = true;
            $response['message'] = "User Does Not Exist";
        }
        echo json_encode($response);
    }
    
    function loginToServer($username,$password1) {
        $cryptID;
        
        $comparable;
		// echo "hi";
		include 'secure.php';
		$db = mysqli_connect($server,$user,$password,$database);	
		// echo "hello";
		//
		$username = mysqli_real_escape_string($db, $username);
        if ($call = mysqli_query($db, "CALL login('$username')")) {
            // echo "there";
            while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                // echo "here";
                $cryptID = $row[1];
                $comparable = $row[2];
            }           
        }
        // echo $comparable;
        // exit;
        
        if (!(password_verify($password1, $comparable))) {
            header('location: failedlogin.php');
        } else {
            $rows = mysqli_num_rows($call);
            //echo $rows."<br>";
            
            if ($rows != 0) {

                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['cid'] = $cryptID;
                $call->close();
                $db->next_result();
                $call = mysqli_query($db, "CALL getBasicInfo('$cryptID')");
                $row = mysqli_fetch_array($call, MYSQLI_BOTH);
                $_SESSION['fname'] = $row['firstname'];
                $_SESSION['lname'] = $row['lastname'];
                $_SESSION['birthdate'] = $row['birthdate'];
                $_SESSION['pnumber'] = $row['pnumber'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['preference'] = $row['runnertype'];
                $_SESSION['city'] = $row['city'];
                $_SESSION['state'] = $row['state'];
                $_SESSION['profilepic'] = $row['img_filepath'];
                $_SESSION['biography'] = $row['biography'];
                $call->free();
                $db->next_result();
                header('Location: home.php');
                
            } else {
                header('Location: index.php');
            }
        }
    }
?>
