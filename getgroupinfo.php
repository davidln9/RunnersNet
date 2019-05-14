<?php
    include 'sessioncheck.php';
    
    if (isset($_POST['btnSubmitName'])) {
        $_SESSION['groupname'] = $_POST['name'];
        if ($_POST['name'] != "")
            header('location: groupsetup2.php');
        else
            header('location: groupsetup1.php?error=1');
    }
    if (isset($_POST['btnSubmitType'])) {
        $_SESSION['grouptype'] = $_POST['grouptype'];
        header('location: groupsetup3.php');
    }
    if (isset($_POST['btnSubmitMethod'])) {
        $_SESSION['method'] = $_POST['joinmethod'];
        header('location: groupsetup4.php');
    }
    if (isset($_POST['btnSubmitLocation'])) {
        $_SESSION['location'] = $_POST['states']." ".$_POST['city'];
        if ($_POST['city'] == "")
            header("location: groupsetup4.php?error=1");
        else
            header("location: groupsetup5.php");
    }
    if (isset($_POST['btnSubmitBio'])) {
        $_SESSION['bio'] = $_POST['txtBio'];
        
        if ($_POST['txtBio'] == "")
            header("location: groupsetup5.php?error=1");
        else
            header("location: groupsetup6.php");
    }
    if (isset($_POST['btnSubmitMod'])) {
        $_SESSION['mod'] = $_POST['rdbMod'];
        header("location: groupsetup7.php");
    }
?>