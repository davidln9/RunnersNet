<?php
include 'sessioncheck.php';

if (isset($_POST['trust'])) {
    $userID = $_POST['userID'];
    $groupID = $_POST['groupID'];
    
    // echo $userID." ".$groupID;
    
    if ($call = mysqli_query($db, "CALL TRUSTMEMBER($userID, $groupID)")) {
        header("location: groupnotifications.php?id=$groupID");
    } else {
        echo "tm: ".mysqli_error($db);
    }
}
?>