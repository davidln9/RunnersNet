<?php
include 'sessioncheck.php';
if (isset($_POST['btnReport'])) {
    
    // echo "here";
    $stalking = isset($_POST['report1']) ? 1 : 0;
    $bullying = isset($_POST['report2']) ? 1 : 0;
    $advertising = isset($_POST['report3']) ? 1 : 0;
    $posting = isset($_POST['report4']) ? 1 : 0;
    $details = $_POST['txtReportUser'];
    $guilty = $_POST['malicious'];
    $details = mysqli_real_escape_string($db, $details);
    echo $stalking." ".$bullying." ".$advertising." ".$posting." ".$guilty." ".$details."<br>";
    
    date_default_timezone_set('MST');
    $date = date("m/d/Y g:i a");
    if (!($call = mysqli_query($db, "CALL REPORTUSER($cid, $guilty, '$date', $stalking, $bullying, $advertising, $posting, '$details')"))) {
        echo "line 15: ".mysqli_error($db);
    } 
    header("location: reportconfirmation.php");
}
?>