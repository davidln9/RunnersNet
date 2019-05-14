<?php
    include 'sessioncheck.php';
    if (isset($_POST['btnSubmitShoes'])) {
        if ($_POST['brand'] == "" || $_POST['name'] == "" || $_POST['year'] == "") {
            header("location: addshoes.php?err=1");
        } else {
            $brand = mysqli_real_escape_string($db, $_POST['brand']);
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $year = intval(mysqli_real_escape_string($db, $_POST['year']));
        }
        if ($call = mysqli_query($db, "CALL ADDNEWSHOES($cid, '$brand', '$name', $year)")) {
            
            
            header("location: addshoes.php?err=0");
        } else {
            echo mysqli_error($db);
        }
    }
?>
