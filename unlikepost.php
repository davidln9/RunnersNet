<?php
include 'sessioncheck.php';
$posttype = (isset($_GET['posttype'])) ? $_GET['posttype'] : null ;
$postID = (isset($_GET['postID'])) ? $_GET['postID'] : null ;
$user = (isset($_GET['user'])) ? $_GET['user'] : null;
$liker = isset($_GET['liker']) ? $_GET['liker'] : null;

if ($liker == "undefined" || $liker == null)
    $liker = $cid;

// echo $posttype." ".$postID." ".$page." ".$user;
// exit;

if (!($call = mysqli_query($db, "CALL UNLIKEPOST($posttype, $postID, $liker)"))) {
    echo myqli_error($db);
    exit;
} 

if (!($call = mysqli_query($db, "CALL REMOVENOTIFICATION($posttype, 0, $postID, $liker, $user, 0)"))) {
    echo mysqli_error($db);
    exit;
}


?>