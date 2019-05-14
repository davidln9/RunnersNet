<?php
    include 'sessioncheck.php';
    
    $temp = isset($_GET['id']) ? $_GET['id'] : null;
    $page = isset($_GET['page']) ? $_GET['page'] : null;
    $page = intval($page);
    $requester = intval($temp);
    $pageurl = "rand.php";
    
    
    if ($call = mysqli_query($db, "CALL DenyRequest('$requester','$cid')")) {
        if ($page == 0) {
            header("location: notifications.php");
        } elseif ($page == 1) {
            header("location: viewprofile.php?id=$requester");
        }
        
    } else {
        echo "acceptrequest: ".mysqli_error($db);
    }
    ?>
