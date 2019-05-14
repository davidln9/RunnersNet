<?php
    include 'sessioncheck.php';
    
    if (isset($_POST['btnSubmitType'])) {
        $val = intval($_POST['type']);
        switch ($val) {
            case 1:
                header('location: distanceform1.php');
                break;
            case 2:
                header('location: speedform1.php');
                break;
            case 3:
                header('location: raceform1.php');
                break;
            default:
                echo "<p>Select one</p>";
                break;
        }
    }
    ?>
