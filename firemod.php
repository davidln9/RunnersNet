<?php
include 'sessioncheck.php';

$group = isset($_POST['id']) ? $_POST['id'] : null;
$moderator = isset($_POST['user']) ? $_POST['user'] : null;
$type = isset($_POST['type']) ? $_POST['type'] : null;

if ($type == 1) {
    if ($call = mysqli_query($db, "CALL RELIEVEMODERATOR($moderator, $group)")) {
        echo "Undo Fire";
    } else {
        echo "error1".mysqli_error($db);
    }
} elseif ($type == 2) {
    if ($call = mysqli_query($db, "CALL UNDORELIEVEMODERATOR($moderator, $group)")) {
        echo "Fire";
    } else {
        echo "error2";
    }
} elseif ($type == 3) {
    if ($call = mysqli_query($db, "CALL REMOVEGROUPMEMBER($moderator, $group)")) {
        echo "Undo Remove";
    } else {
        echo "error3";
    }
} elseif ($type == 4) {
    if ($call = mysqli_query($db, "CALL UNDOREMOVEGROUPMEMBER($moderator, $group)")) {
        echo "Remove";
    } else {
        echo "error4";
    }
}
?>