<?php
    include 'sessioncheck.php';
    
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    
    if ($action == "profile") {
    
        if (isset($_POST['btnChangeBio'])) {
            $bio = mysqli_real_escape_string($db, $_POST['thebio']);
            $call = mysqli_query($db, "CALL ChangeBio('$cid','$bio')");
            if (!$call) {
                echo "changebio: ".mysqli_error($db);
            } else {
                $_SESSION['biography'] = stripcslashes($bio);
                header('location: editprofile.php?id=1');
            }
        }
    } elseif ($action == "group") {
        
        if (isset($_POST['btnChangeBio'])) {
            $bio = mysqli_real_escape_string($db, $_POST['thebio']);
            $group = $_POST['group'];
            $call = mysqli_query($db, "CALL UPDATEGROUPBIO('$bio', $group)");
            if (!$call) {
                echo "UPDATEGROUPBIO: ".mysqli_error($db);
            } else {
                $_SESSION['biography'] = stripcslashes($bio);
                header("location: editprofile.php?id=2&group=$group");
            }
        }
    }
    ?>
