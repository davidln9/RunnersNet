<?php
    include 'sessioncheck.php';
    
    if (isset($_POST['btnSubmitDate'])) {
        if ($_POST['date'] == "") {
            header('location: raceform.php');
        } else {
            $_SESSION['date'] = $_POST['date'];
            header('location: raceform1.php');
        }
    }
    if (isset($_POST['btnSubmitLoc'])) {
        $location = $_POST['location'];
        if ($location == "") {
            header('location: raceform1.php');
        } else {
            $_SESSION['location'] = $location;
            header('location: raceform2.php');
        }
    }
    if (isset($_POST['btnSubmitName'])) {
        $name=$_POST['name'];
        if ($name=="") {
            header('location: raceform2.php');
        } else {
            $_SESSION['racename'] = $name;
            header('location: raceform3.php');
        }
    }
    if (isset($_POST['btnSubmitRelay'])) {
        $relay = $_POST['relay'];
        $_SESSION['relay'] = $relay;
        header('location: raceform4.php');
    }
    if (isset($_POST['btnSubmitTime'])) {
        $time=$_POST['time'];
        if ($time=="") {
            header('location: raceform4.php');
        } else {
            $_SESSION['timeofday'] = $time;
            header('location: raceform5.php');
        }
    }
    if (isset($_POST['btnSubmitLength'])) {
        $length=$_POST['length'];
        if ($length=="") {
            header('location: raceform5.php');
        } else {
            $_SESSION['length'] = $length;
            header('location: raceform6.php');
        }
    }
    if (isset($_POST['btnSubmitRunTime'])) {
        
        $_SESSION['runtime'] = $_POST['runtime'];
        
        $length = $_SESSION['length'];
        $time = $_SESSION['runtime'];
        
        include 'pacecalc.php';
        
        $calculator = new PaceCalculator();
        
        $_SESSION['avgRacePace'] = $calculator->calculatePace($_SESSION['length'], $_POST['runtime']);
        
        header('location: raceform7.php');
    }
    if (isset($_POST['btnSubmitJournal'])) {
        $journal=$_POST['txtJournal'];
        $uname = $_SESSION['username'];
        $length = floatval($_SESSION['length']);
        $time = $_SESSION['timeofday'];
        $location = $_SESSION['location'];
        $racename = $_SESSION['racename'];
        $relay = $_SESSION['relay'];
        $runtime = $_SESSION['runtime'];
        $date = $_SESSION['date'];
        $date = $date." ".$time;
        $avgPace = $_SESSION['avgRacePace'];
        
        $call = mysqli_query($db, "CALL getRaceID");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            $row = mysqli_fetch_assoc($call);
            $call->close();
            $db->next_result();
            $id = intval($row["LastEntry"]) + 1;
        }
        
        $journal = mysqli_real_escape_string($db, $journal);
        $location = mysqli_real_escape_string($db, $location);
        $call = mysqli_query($db, "CALL setRace('$cid','$id','$length','$date','$location','$racename','$relay','$runtime','$avgPace','$journal')");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            header('location: profilepage.php');
        }
    }
    ?>
