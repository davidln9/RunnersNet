<?php
include 'sessioncheck.php';
include 'sendnotification.php';

if (isset($_POST['btnAcceptRequest'])) {
    $group = $_POST['group'];
    $liker = $_POST['liker'];
    if ($call = mysqli_query($db, "CALL APPOINTMODERATOR($cid, $group)")) {
        $action = new SendNotification;
        $action->notify(-1,12,-1,$group,$db,$cid,0);    
        $action->unNotify(-1,11,-1,$cid,$db,$liker,$group);
        unset($action);
        header("location: notifications.php");
    } else {
        header("location: notifications.php?error=1");
    }
}
?>
