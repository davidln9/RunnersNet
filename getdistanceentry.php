<?php
    include 'sessioncheck.php';
    
    if (isset($_POST['btnSubmitPub'])) {
        $val = intval($_POST['pub']);
        $_SESSION['public'] = $val;
        header('location: distanceform2.php');
    }
    if (isset($_POST['btnSubmitDateTime'])) {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $datetime = $date." ".$time;
        echo $datetime;
        date_default_timezone_set('MST');
        $realdate = date("m/d/Y g:i a");
        if ($date == "") {
            header('location: distanceform2.php?error=1');
        } else if ($time == "") {
            header('location: distanceform2.php?error=1');
        } else if (strtotime($datetime) < $realdate) {
            header('location: distanceform2.php?error=2');
            
        } else {
            $_SESSION['datetime'] = $datetime;
            header('location: distanceform3.php');
        }
    }
    if (isset($_POST['btnSubmitLength'])) {
        $length=$_POST['length'];
        if ($length=="") {
            header('location: distanceform3.php');
        } else {
            $length = doubleval($length);
            $_SESSION['distance'] = $length;
            header('location: distanceform5.php');
        }
    }
    if (isset($_POST['btnSubmitLoc'])) {
        $location=$_POST['location'];
        if ($location=="") {
            header('location: distanceform5.php');
        } else {
            $_SESSION['location'] = $location;
            header('location: distanceform6.php');
        }
    }
    if (isset($_POST['btnSubmitTeam'])) {
        $team=$_POST['team'];
        if ($team=="") {
            header('location: distanceform6.php');
        } else {
            $_SESSION['team'] = $team;
            header('location: distanceform7.php');
        }
    }
    if (isset($_POST['btnSubmitIntensity'])) {
        if ($_POST['optintensity'] == "low") {
            $intensity=1;
        } elseif ($_POST['optintensity'] == "lowmed") {
            $intensity=2;
        } elseif ($_POST['optintensity'] == "medium") {
            $intensity=3;
        } elseif ($_POST['optintensity'] == "medhigh") {
            $intensity=4;
        } else {
            $intensity=5;
        }
        $_SESSION['intensity'] = $intensity;
        header('location: distanceform10.php');
    }
    if (isset($_POST['btnSubmitShoe'])) {
        
        $_SESSION['shoe'] = $_POST['shoeselection'];
        header('location: distanceform8.php');
    }
    if (isset($_POST['btnSubmitRunTime'])) {
        $runtime = $_POST['runtime'];
        $_SESSION['runtime'] = $runtime;
        $length = $_SESSION['distance'];
        
        include 'pacecalc.php';
        
        $calculator = new PaceCalculator();
        
        $_SESSION['avgPace'] = $calculator->calculatePace($length, $runtime);
        unset($calculator);
        
        header('location: distanceform9.php');
    }
    if (isset($_POST['btnSubmitJournal'])) {
        
        $public = intval($_SESSION['public']);
        $length = floatval($_SESSION['distance']);
        $time = $_SESSION['timeofday'];
        $team = $_SESSION['team'];
        $intensity = intval($_SESSION['intensity']);
        $runtime = $_SESSION['runtime'];
        $date = $_SESSION['datetime'];
        $avgPace = $_SESSION['avgPace'];
        $type = 0;
        
        //$datetime = $date." ".$time;
        $journal=mysqli_real_escape_string($db, $_POST['txtJournal']);
        $location = mysqli_real_escape_string($db, $_SESSION['location']);
        
        $call = mysqli_query($db, "CALL getRunID");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            $id = intval($row['id']) + 1;
            $call->close();
            $db->next_result();
        }
        $shoeID = $_SESSION['shoe'];
        
        $call = mysqli_query($db, "CALL setDistance('$type','$cid','$public','$date','$location','$team','$intensity','$journal','$runtime','$avgPace','$id','$length', $shoeID)");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            header('location: home.php');
        }
    }
    ?>
