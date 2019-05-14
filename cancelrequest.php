<?php
    include 'sessioncheck.php';
    
    $temp = isset($_GET['id']) ? $_GET['id'] : null;
    $oops = intval($temp);
    
    if ($call = mysqli_query($db, "CALL CancelRequest('$cid','$oops')")) {
        if ($call = mysqli_query($db, "CALL REMOVENOTIFICATION(-1, 2, -1, $cid, $oops, 0)")) {
            header('location: viewprofile.php?id='.$oops);
        }
        
    } else {
        echo "acceptrequest: ".mysqli_error($db);
    }
    ?>
