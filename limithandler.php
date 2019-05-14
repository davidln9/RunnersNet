<?php
    include 'sessioncheck.php';
    if (isset($_POST['btnSubmitLimits'])) {
        $dist = intval($_POST['optDistance']);
        $races = intval($_POST['optRaces']);
        $speed = intval($_POST['optSpeed']);
        $posts = intval($_POST['optPosts']);
        $pgposts = intval($_POST['optPagePosts']);
        $grpposts = intval($_POST['optGrpPosts']);
        $grppgposts = intval($_POST['optGrpPagePost']);
        
        if ($call = mysqli_query($db, "CALL UPDATELIMITS($cid, $dist, $speed, $races, $posts, $pgposts, $grpposts, $grppgposts)")) {
            header('location: editprofile.php?id=1&msg=5');
        } else {
            echo mysqli_error($db);
        }
    }
?>
