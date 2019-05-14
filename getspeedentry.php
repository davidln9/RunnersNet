<?php
    include 'sessioncheck.php';
    
    if (isset($_POST['btnSubmitPub'])) {
        $val = intval($_POST['pub']);
        $_SESSION['public'] = $val;
        // echo $val;
        header('location: speedform2.php');
    }
    if (isset($_POST['btnSubmitDateTime'])) {
        $date = $_POST['date'];
        $time = $_POST['time'];
        // echo $date." ".$time;
//         exit;
        $datetime = $date." ".$time;
        date_default_timezone_set('MST');
        $realdate = date("m/d/Y g:i a");
        if ($date == "") {
            header('location: speedform2.php?error=1');
        } else if ($time == "") {
            header('location: speedform2.php?error=1');
        } else if (strtotime($datetime) < $realdate) {
            header('location: speedform2.php?error=2');
            
        } else {
            $_SESSION['datetime'] = $datetime;
            // echo $datetime."<br>".$_SESSION['public'];
            header('location: speedform3.php');
        }
    }
    if (isset($_POST['btnSubmitLoc'])) {
        
        if ($_POST['location']=="") {
            header('location: speedform3.php');
        } else {
            $_SESSION['location'] = $_POST['location'];;
            // echo $_SESSION['location'];
            header('location: speedform4.php');
        }
    }
    if (isset($_POST['btnSubmitDescription'])) {
        
        if ($_POST['description'] == "") {
            header("location: speedform4.php?error=1");
        } else {
            $_SESSION['description'] = $_POST['description'];
            // echo $_SESSION['description'];
            header("location: speedform5.php");
        }
    }
    
    if (isset($_POST['btnSubmitTeam'])) {
        $team = $_POST['team'];
        if ($team == "") {
            $team = "myself";
        } 
        $_SESSION['team'] = $team;
        // echo $_SESSION['team'];
        header('location: speedform6.php');
    }
    if (isset($_POST['btnSubmitDist'])) {
        if ($_POST['warmup'] == "" || $_POST['workout'] == "" || $_POST['cooldown'] == "")
            header("location: speedform6.php?error=1");
        else {
            $_SESSION['warmup'] = floatval($_POST['warmup']);
            $_SESSION['workout'] = floatval($_POST['workout']);
            $_SESSION['cooldown'] = floatval($_POST['cooldown']);
            // echo $_SESSION['distance'];
            header('location: speedform7.php');
        }
    }
    
    if (isset($_POST['btnSubmitJournal'])) {
        
        $public = intval($_SESSION['public']); //
        $warmup = floatval($_SESSION['warmup']); //
        $workout = floatval($_SESSION['workout']);
        $cooldown = floatval($_SESSION['cooldown']);
        $datetime = $_SESSION['datetime']; //
        $team = $_SESSION['team']; //
        $description = $_SESSION['description']; //
        $journal = $_POST['txtJournal']; //
        
        $length = $warmup + $workout + $cooldown;

        //$datetime = $date." ".$time;
        $journal=mysqli_real_escape_string($db, $_POST['txtJournal']);
        $location = mysqli_real_escape_string($db, $_SESSION['location']);
        $id;
        $call = mysqli_query($db, "CALL GETSPEEDID");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            $id = intval($row['id']) + 1;
            $call->free();
            $db->next_result();
        }
        
        if (!($call = mysqli_query($db, "CALL INSERTSPEEDWORKOUT($id, $cid, '$location', '$datetime', '$description', $length, '$team', '$journal', $public, $warmup, $cooldown, $workout)"))) {
            echo "INSERT: ".mysqli_error($db);
            exit;
        } else {
            header("location: home.php");
        }
        
    }
    ?>
