<?php
    include 'sessioncheck.php';
    include 'sendnotification.php';
    $temp = isset($_GET['id']) ? $_GET['id'] : null;
    $temp3 = isset($_GET['page']) ? $_GET['page'] : null;
    $page = intval($temp3);
    $newfriend = intval($temp);
    //echo $newfriend;
    date_default_timezone_set('MST');
    $date = new DateTime($datein);
    
    $pageurl = "rand.php";
    if ($page == 0) {
        $pageurl = "notifications.php";
    }
    if ($page == 1) {
        $pageurl = "viewprofile.php?id=$newfriend";
    }
    
    if ($call = mysqli_query($db, "CALL UNDODENY('$cid','$newfriend')")) {
        //echo $newfriend;
        
        //header("location: $pageurl");
        
    } else {
        echo "acceptrequest: ".mysqli_error($db);
    }
    
    $action = new SendNotification();
    $send = $action->notify(-1,3,-1,$newfriend, $db, $cid, 0);
    
    if (!($send)) {
        echo "no luck";
    } else {
        if ($page == 0) {
            header("location: notifications.php");
        } elseif ($page == 1) {
            header("location: viewprofile.php?id=$newfriend");
        }
    }
    ?>
