<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) < strtotime($b['date']);
    }
    ?>
<!DOCTYPE html>
<html>
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Notifications</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    $groupid = isset($_GET['id']) ? $_GET['id'] : null;
    ?>
</header>

<?php
$admin;
$verified = false;

if ($call = mysqli_query($db, "CALL GETMYGROUPS($cid)")) {
    while ($row = mysqli_fetch_array($call)) {
        if ($row['groupID'] == $groupid && ($row['permissions'] == 2 || $row['permissions'] == 3)) {
            $verified = true;
        }
    }
    $call->free();
    $db->next_result();
} else {
    echo "GETGROUPMEMBERS: ".mysqli_error($db); 
}
if ($verified) {
    if ($call = mysqli_query($db, "CALL GETGROUPINFO($groupid)")) {
        while ($row = mysqli_fetch_array($call)) {
            $policy = $row['policy'];
            $pagepolicy = $row['pagepolicy'];
        }
        $call->free();
        $db->next_result();
    } else {
        echo "grpinfo: ".mysqli_error($db);
    }
    $untrusted = array();
    $ui = 0;
    if ($pagepolicy == 1) {
        
        if ($call = mysqli_query($db, "CALL GETGROUPMEMBERS($groupid)")) {
            
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                if ($row['permissions'] == 0) {
                    $untrusted[$ui] = $row['cryptID'];
                    $ui++;
                }
            }
            $call->free();
            $db->next_result();
        } else {
            echo "grpmembers: ".mysqli_error($db);
        }
    }
    $groupnotifs = array(); //be sure to unset at end
    $ni = 0;
    if ($call = mysqli_query($db, "CALL GETNOTIFICATIONS($groupid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $groupnotifs[$ni]['posttype'] = $row['posttype'];
            $groupnotifs[$ni]['notifType'] = $row['notifType'];
            $groupnotifs[$ni]['postID'] = $row['postID'];
            $groupnotifs[$ni]['notifier'] = $row['notifier'];
            $groupnotifs[$ni]['date'] = $row['date'];
            $groupnotifs[$ni]['status'] = $row['status'];
        
            $ni++;
        }
        $call->free();
        $db->next_result();
    } else {
        echo "GETNOTIFICATIONS: ".mysqli_error($db);
    }

    usort($groupnotifs, "datesort");
    
    $fname;
    $lname;
    $basicinfo = $db->prepare("CALL GETBASICINFO(?)");
    echo "<div class='notifbody'>";
    echo "<div class='friendrequests'>";
    if ($ui == 0) {
        echo "<div class='friendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<p>No Untrusted Members</p>";
        echo "</div>"; //content
        echo "</div>"; //floater
        echo "</div>"; //friendnotifs
    }
    for ($i = 0; $i < $ui; $i++) {
        $uID = $untrusted[$i];
        $basicinfo->bind_param("i", $uID);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        while ($row = $result->fetch_assoc()) {
            $fname = $row['firstname'];
            $lname = $row['lastname'];
            $pic = $row['img_filepath'];
        }
        $db->next_result();
        echo "<div class='newfriendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<div class='requesterpic'>";
        echo profilepic::getPic(50, $pic);
        echo "</div>"; //closes requesterpic
        echo "<a href='viewprofile.php?id=$uID'>".$fname." ".$lname."</a> needs to be trusted<br>";
        echo "<form action='approvemember.php' name='trustform' id='trustform' method='post'>";
        echo "<input type='hidden' name='userID' id='userID' value='$uID'>";
        echo "<input type='hidden' name='groupID' id='groupID' value='$groupid'>";
        echo "<input type='submit' name='trust' id='trust' value='Approve'>";
        echo "<input type='submit' name='deny' id='deny' value='Reject'>";
        echo "</form>";
        echo "</div>"; //closes content
        echo "</div>"; //closes floater
        echo "</div>"; //closes friendnotifs
    }
    echo "</div>";
    echo "<div class='notifs'>";
    for ($i = 0; $i < $ni; $i++) {
        $pt = $groupnotifs[$i]['posttype'];
        $nt = $groupnotifs[$i]['notifType'];
        $pID = $groupnotifs[$i]['postID'];
        $ntfr = $groupnotifs[$i]['notifier'];
        $date = $groupnotifs[$i]['date'];
        
        $basicinfo->bind_param("i", $ntfr);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        while ($row = $result->fetch_assoc()) {
            $fname = $row['firstname'];
            $lname = $row['lastname'];
            $pic = $row['img_filepath'];
        }
        $db->next_result();
        echo "<div class='friendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<div class='requesterpic'>";
        echo profilepic::getPic(50, $pic);
        echo "</div>"; //closes rpic
        switch ($nt) {
            case 0:
            echo $fname." ".$lname." liked your post<br><button onclick='viewPost($pt, $pID, $ntfr)'>View</button><button onclick='deleteNotif($pt,$pID,$ntfr,$nt,$groupid)'>Clear</button>";
            break;
            case 1: //comment
            echo $fname." ".$lname." commented on your post<br><button onclick='viewPost($pt, $pID, $ntfr)'>View</button><button onclick='deleteNotif($pt,$pID,$ntfr,$nt,$groupid)'>Clear</button>";
            break;
            case 6:
            echo $fname." ".$lname." posted onto the group's page<br><button onclick='viewPost($pt, $pID, $ntfr)'>View</button><button onclick='deleteNotif($pt,$pID,$ntfr,$nt,$groupid)'>Clear</button>";
            break;
            case 12:
            echo $fname." ".$lname." accepted your moderator request<br><button onclick='deleteNotif($pt,$pID,$ntfr,$nt,$groupid)'>Clear</button>";
            break;
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Nope";
}
echo "<button onclick='back($groupid)'>Back</button>";
?>
</div>
<script>
    function viewPost(posttype, postID, person) {
        window.location.href="home.php?type=view&id=" + postID + "&ptype=" + posttype + "&person=" + person;
    }
    function deleteNotif(posttype, postID, person, nid, grpid) {
        window.location.href="deletenotification.php?type=" + posttype + "&id=" + postID + "&person1=" + person + "&nid=" + nid + "&group=0&page=2&uid=" + grpid;
    }
    function back(groupid) {
        window.location.href="admintools.php?id="+groupid;
    }
    </script>
</body>
</html>

