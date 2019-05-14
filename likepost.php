<?php
include "sessioncheck.php";
// echo "here";

//GET THE values from the header
$postid = (isset($_GET['id'])) ? $_GET['id'] : null;
$type = (isset($_GET['type'])) ? $_GET['type'] : null;
$poster = (isset($_GET['poster'])) ? $_GET['poster'] : null;
$liker = isset($_GET['liker']) ? $_GET['liker'] : null;

if ($liker == null || $liker == "undefined") {
    $liker = $cid;
}
//$page = (isset($_GET['page'])) ? $_GET['page'] : null;

// echo $postid." ".$type." ".$poster." ".$liker;
// exit;

//get the date
date_default_timezone_set('MST');
$date = date("m/d/Y g:i a");
// echo $date;

//insert like into the database at table 'LIKES'
if (!($call = mysqli_query($db, "CALL LIKEPOST($type, $postid, $poster, $liker, '$date')"))) {
    
    echo "likepost: ".mysqli_error($db);
    
    exit;
    
} else {
    
    //send notification through class
    require 'sendnotification.php';
    $action = new SendNotification();
    
    $notify = $action->notify($type, 0, $postid, $poster, $db, $liker, 0);
   
// echo $notify;
    
}

?>