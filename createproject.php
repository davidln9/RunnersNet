<?php
include 'sessioncheck.php';
include_once "profilepic.php";
function datesort($a, $b) {
    if ($a == $b)
        return 0;
    return strtotime($a['date']) < strtotime($b['date']);
}
include 'elapsedtime.php';
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
    <title>Report User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="titlediv">
        <?php
        include 'menu.php';
        ?>
    </div>
</header>
<body>
    <?php
    $firstname;
    $lastname;
    $pic;
    $userid = isset($_GET['id']) ? $_GET['id'] : null ;
    if ($call = mysqli_query($db, "CALL GETBASICINFO($userid)")) {
        while ($row = mysqli_fetch_array($call)) {
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $pic = $row['img_filepath'];
        }
        $call->free();
        $db->next_result();
    } else {
        echo "line 30: ".mysqli_error($db);
    }
    echo "<div class='reportuser'>";
    echo "<div class='regpostfloater'>";
    echo "<span>What is the name of this project?";
    echo "<form id='reportform' name='reportform' method='post' action='generateproject.php'>";
    echo "<input name='report1'></input><br>";
    echo "<input type='checkbox' name='report2'>Bullying You or Another User<br>";
    echo "<input type='checkbox' name='report3'>Advertising or Soliciting on this Website<br>";
    echo "<input type='checkbox' name='report4'>Posting Offensive Content";
    echo "<textarea type='biography' placeholder='Additional details' name='txtReportUser' id='txtReportUser' class='inputtext' rows='5' cols='10'></textarea><br>";
    echo "<input type='hidden' name='malicious' value='$userid'>";
    echo "<input type='submit' name='btnReport' id='btnReport' value='Submit'>";
    echo "</form>";
    echo "</div>"; //closes floater
    echo "</div>"; //closes notfriends
    echo "</div>";
    ?>
</body>
</html>
