<?php
    include 'sessioncheck.php';
    if( isset($_POST['btnCreate']) ) {
        if ($_POST['pass'] == "") {
            header("location: index.php?id=10");
        } else if ($_POST['email'] == "") {
            header("location: index.php?id=10");
        } else if ($_POST['city'] == "") {
            header("location: index.php?id=10");
        } else if ($_POST['state'] == "") {
            header("location: index.php?id=10");
        } else if ($_POST['birthdate'] == "") {
            header("location: index.php?id=10");
        } else if ($_POST['pass'] != $_POST['cpass']) {
            header("location: index.php?id=11");
        } else {
            
            $_SESSION['password'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            
            $_SESSION['username'] = $_POST['email'];
            $_SESSION['pnumber'] = $_POST['pnumber'];
            $_SESSION['city'] = $_POST['city'];
            $_SESSION['state'] = $_POST['state'];
            $_SESSION['birthdate'] = $_POST['birthdate'];
            
            // echo $_SESSION['username']." ".$_SESSION['password']." ".$_SESSION['pnumber']." ".$_SESSION['city']." ".$_SESSION['state']." ".$_SESSION['birthdate'];
            header("location: accountsetup.php");
        }
    }
    if (isset($_POST['btnSubmitName'])) {
        $_SESSION['fname'] = $_POST['firstname'];
        $_SESSION['lname'] = $_POST['lastname'];
        header('location: accountsetup2.php');
    }
    if (isset($_POST['btnSubmitGender'])) {
        $gender;
        if (isset($_POST['male'])) {
            $gender=1;
        } else {
            $gender=0;
        }
        $_SESSION['gender'] = $gender;
        header('location: accountsetup3.php');
    }
    if (isset($_POST['btnSubmitPref'])) {
        $_SESSION['preference'] = $_POST['preference'];
        
        header('location: accountsetup6.php');
    }
    if (isset($_POST['btnSubmitShoe'])) {
        $year = $_POST['year'];
        $make = $_POST['make'];
        $name = $_POST['name'];
        $cid = $_SESSION['cid'];
        if ($call = mysqli_query($db, "CALL ADDNEWSHOES($cid, '$make', '$name', '$year')")) {
            header('location: home.php');
        } else {
            echo mysqli_error($db);
            echo "Bad";
        }
        
        //header('location: accountsetup5.php');
    }
    
    if (isset($_POST['btnSubmitBio'])) {
        $theUname = $_SESSION['username'];
        $thefname = mysqli_real_escape_string($db, $_SESSION['fname']);
        $thelname = mysqli_real_escape_string($db, $_SESSION['lname']);
        $thegender = $_SESSION['gender'];
        $thepref = $_SESSION['preference'];
        $pnumber = "NOTYET";
        $city= mysqli_real_escape_string($db, $_SESSION['city']);
        $state= mysqli_real_escape_string($db, $_SESSION['state']);
        $birthdate=mysqli_real_escape_string($db, $_SESSION['birthdate']);
        $img=$_SESSION['profilepic'];
        $cryptID = mt_rand(0,200000000);
        $cryptcheck = array();
        $index = 0;
        
        $password = $_SESSION['password'];
        $_SESSION['password'] = "";
        $bio = mysqli_real_escape_string($db, $_POST['txtBio']);
        

        //echo $cryptID;
        if ($call = mysqli_query($db, "CALL CheckCryptID")) {
            //echo "called";
            while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                //echo "<br>yes";
                $cryptcheck[$index] = intval($row[0]);
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo mysqli_error($db);
        }
        if ($call = mysqli_query($db, "CALL CHECKGROUPID")) {
            //echo "called";
            while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                //echo "<br>yes";
                $cryptcheck[$index] = intval($row[0]);
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo mysqli_error($db);
        }
        
        for ($i = 0; $i < $index; $i++) {
            if ($cryptID == $cryptcheck[$i]) {
                $cryptID = mt_rand(0,2000000000);
                $i = 0;
            }
        }
        $_SESSION['cid'] = $cryptID;
        if ($call = mysqli_query($db, "CALL CheckUser('$theUname')")) {
            $in = 0;
            while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                $in++;
            }
            //echo $in;
            if ($in > 0) {
                header('location: index.php?id=12');
                exit;
            }
            $call->free();
            $db->next_result();
        }
        
        
        if ($call = mysqli_query($db, "CALL CreateNewUser('$theUname','$password','$cryptID')")) {
            
        } else {
            echo "Register: ".mysqli_error($db);
            exit;
        }
        if ($call = mysqli_query($db, "CALL setBasicInfo('$birthdate','$pnumber','$city','$state','$img','$thefname','$thelname','$thegender','$thepref','$bio','$cryptID')")) {
         
            $_SESSION['loggedin'] = true;
            $_SESSION['cid'] = $cryptID;
            header('location: accountsetup7.php');
        } else {
            echo mysqli_error($db);
        }
    }
?>
