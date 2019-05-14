<?php
    session_start();
	include 'secure.php';
	$db;
    $uname;
    $cid;
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $uname = $_SESSION['username'];
        $cid = $_SESSION['cid'];
		$db = mysqli_connect($server,$user,$password,$database) or die("no connection");		
//         if ($mysqli->connect_errno) {
//             echo "no connection";
//         }
    } else {
        $response = array();
        $response['error'] = true;
        $response['message'] = "User Not Logged In";
        echo json_encode($response);
        exit();
        
    }
    ?>
