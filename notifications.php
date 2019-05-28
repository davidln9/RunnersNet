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
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Notifications</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
include 'menu.php';
usort($notifications, "datesort");
$requests = 0;
$friendreqs = array();

for ($i = 0; $i < $notifs; $i++) {
    if ($notifications[$i]['notifType'] == 2) {
        $friendreqs[$requests]['notifier'] = $notifications[$i]['notifier'];
        $friendreqs[$requests]['type'] = $notifications[$i]['notifType'];
        $requests++;
    } 
}
    
        ?>
</div>
</header>
<body>

<?php
echo "<div class='notifbody'>";
echo "<div class='friendrequests'>";
$requesterID;
if ($requests == 0) {
    echo "<div class='friendnotifs'>";
    echo "<div class='notiffloater'>";
    echo "<div class='content'>";
    echo "<p>No friend requests</p>";
    echo "</div>"; //content
    echo "</div>"; //floater
    echo "</div>"; //friendnotifs
}
$basicinfo = $db->prepare("CALL GETBASICINFO(?)");
for ($f=0; $f<$requests; $f++) {
    $requesterID = $friendreqs[$f]['notifier'];
    // echo $requesterID;
    $firstname;
    $lastname;
    $image;
    $basicinfo->bind_param("i", $requesterID);
    $basicinfo->execute();
    $result = $basicinfo->get_result();
    
    while ($row = $result->fetch_assoc()) {
        
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $image = $row['img_filepath'];
    }
    
    $db->next_result();
        
     
    if ($friendreqs[$f]['status'] == 0) {
        echo "<div class='newfriendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<div class='requesterpic'>";
        echo profilepic::getPic(50, $image);
        echo "</div>"; //closes requesterpic
        echo $firstname." ".$lastname." wants to friend you<br>";
        ?>
        <input type='button' name='btnAccept' id='btnAccept' onclick="acceptRequest(<?php echo $requesterID; ?>)" value='Accept'>
        <input type='button' name='btnDeny' id='btnDeny' onclick="denyRequest(<?php echo $requesterID; ?>)" value='Deny'>
<?php
        echo "</div>"; //closes content
        echo "</div>"; //closes floater
        echo "</div>"; //closes friendnotifs
    } else if ($friendreqs[$f]['status'] == 1) {
        echo "<div class='friendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<div class='requesterpic'>";
        echo profilepic::getPic(50, $image);
        echo "</div>"; //closes requesterpic
        echo $firstname." ".$lastname." wants to friend you<br>";
        ?>
        <input type='button' name='btnAccept' id='btnAccept' onclick="acceptRequest(<?php echo $requesterID; ?>)" value='Accept'>
        <input type='button' name='btnDeny' id='btnDeny' onclick="denyRequest(<?php echo $requesterID; ?>)" value='Deny'>
<?php
        echo "</div>"; //closes content
        echo "</div>"; //closes floater
        echo "</div>"; //closes friendnotifs
    } else {
        echo "<div class='friendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<div class='picresults'>";
        echo profilepic::getPic(50, $image);
        echo "</div>"; //closes requesterpic
        echo $firstname." ".$lastname." wants to friend you<br>";
        ?>
        <input type='button' name='btnAccept' id='btnAccept' onclick="acceptRequest(<?php echo $requesterID; ?>)" value='Accept'>
        <input type='button' name='btnDeny' id='btnDeny' onclick="denyRequest(<?php echo $requesterID; ?>)" value='Deny'>
<?php
        echo "</div>"; //closes content
        echo "</div>"; //closes floater
        echo "</div>"; //closes friendnotifs
    }
    
}
echo "</div>";
// echo "hi";
echo "<div class='notifs'>";
if ($notifs == 0) {
    echo "<div class='friendnotifs'>";
    echo "<div class='notiffloater'>";
    echo "<div class='content'>";
    echo "<p>No notifications</p>";
    echo "</div>"; //content
    echo "</div>"; //floater
    echo "</div>"; //friendnotifs
}
$groupstmt = $db->prepare("CALL GETGROUPINFO(?)");
for ($i = 0; $i < $notifs; $i++) {
    // echo "hi";
    $pt = $notifications[$i]['posttype'];
    $pID = $notifications[$i]['postID'];
    $nt = $notifications[$i]['notifType'];
    $group = $notifications[$i]['group'];
    if ($nt != 2) {
    
        $liker = $notifications[$i]['notifier'];
        // echo $liker;
        $likerfname;
        $likerlname;
        $likerpic;
        $basicinfo->bind_param("i", $liker);
        $basicinfo->execute();
        $result = $basicinfo->get_result();
        $human = false;
        while ($row = $result->fetch_assoc()) {
            $likerpic = $row['img_filepath'];
            $likerfname = $row['firstname'];
            $likerlname = $row['lastname'];
            $human = true;
        }
        $db->next_result();
        if (!$human) {
            $groupstmt->bind_param("i", $liker);
            $groupstmt->execute();
            $result = $groupstmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $likerpic = $row['img_filepath'];
                $likerfname = $row['name'];
            }
            $db->next_result();
        }
        
        echo "<div class='friendnotifs'>";
        echo "<div class='notiffloater'>";
        echo "<div class='content'>";
        echo "<div class='requesterpic'>";
        echo profilepic::getPic(50, $likerpic);
        echo "</div>"; //closes rpic
        
        switch ($nt) {
            case 0:
            switch ($pt) {
                case 0:
                $query = array("id" => $pID, "type" => $pt);
                $query = http_build_query($query);
                echo $likerfname." liked your run<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 1:
                echo $likerfname." liked your speed workout<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 2:
                echo $likerfname." liked your race<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 3:
                echo $likerfname." liked your post<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 4:
                echo $likerfname." liked your page post<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 5:
                echo $likerfname." liked your 5";
                break;
                case 6:
                echo $likerfname." liked your video<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 7:
                echo $likerfname." liked your page post<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 8:
                echo $likerfname." liked your repost<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                default:
                echo $likerfname." default like";
                break;
            }
            break;
            case 1:
            switch ($pt) {
                case 0:
                echo $likerfname." commented on your run<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 1:
                echo $likerfname." commented on your speed workout<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 2:
                echo $likerfname." commented on your race<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 3:
                echo $likerfname." commented on your post<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 4:
                echo $likerfname." commented on your page post<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 5:
                echo $likerfname." commented on your 5";
                break;
                case 6:
                echo $likerfname." commented on your video<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                case 7:
                echo $likerfname." commented on your page post<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt, $pID, $liker, $nt)'>Clear</button>";
                break;
                case 8:
                echo $likerfname." commented your repost<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
                break;
                default:
                echo $likerfname." default comment";
                break;
            }
            break;
            case 3:
            echo $likerfname." accepted your friend request<br><button onclick='sendMessage($liker)'>Say Hi</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";               
            break;
            case 4:
            echo $likerfname." invited your to join their group<br><button onclick='acceptGroupRequest($group, $liker)'>Join</button><button onclick='viewGroup($group,$liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt, $group)'>Clear</button>";
            break;
            case 5:
            echo $likerfname." invited your to join their event<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteGroupNotif($pt,$pID,$liker,$nt)'>Clear</button>";
            break;
            case 6:
            echo $likerfname." posted on your page<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
            break;
            case 7:
            echo $likerfname." mentioned you<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
            break;
            case 8:
            echo $likerfname." tagged you<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
            break;
            case 9:
            echo $likerfname." accepted your group invite<br><button onclick='deleteNotif($pt,$pID,$liker,$nt,$group)'>Clear</button>";
            break;
            case 10:
            echo $likerfname." accepted your event invite<br><button onclick='deleteNotif($pt,$pID,$liker,$nt,$group)'>Clear</button>";
            break;
            case 11:
            $groupstmt->bind_param("i", $group);
            $groupstmt->execute();
            $result = $groupstmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $gname = $row['name'];
            }
            $db->next_result();
            echo $likerfname." Requests you to be a moderator in his group, $gname";
            echo "<br><form method='post' action='moderator.php' id='moderatorform'>";
            echo "<input type='hidden' value='$group' id='group' name='group'>";
            echo "<input type='hidden' value='$liker' id='liker' name='liker'>";
            echo "<input type='submit' value='Accept' id='btnAcceptRequest' name='btnAcceptRequest'>";
            echo "<input type='submit' value='Deny' id='btnDenyRequest' name='btnDenyRequest'>";
            echo "</form>";
            break;
            default:
            echo $likerfname." default<br><button onclick='viewPost($pt, $pID, $liker)'>View</button><button onclick='deleteNotif($pt,$pID,$liker,$nt)'>Clear</button>";
            break;
        }
        echo "</div>"; //closes content
        echo "</div>"; //closes floater
        echo "</div>"; //closes likenotif
    }
}
echo "</div>";
// echo "</div>";

?>
<script>
function sendRequest(realID) {
    window.location.href="sendrequest.php?id=" + realID + "&page=notifications.php";
    
}
function denyRequest(realID) {
    window.location.href="denyrequest.php?id=" + realID + "&page=0";
}
function acceptRequest(realID) {
    window.location.href="acceptrequest.php?id=" + realID + "&page=0";
}
function acceptGroupRequest(groupID, sender) {
    window.location.href="acceptrequest.php?group=" + groupID + "&page=0&type=1&sender=" + sender;
}
function viewPost(posttype, postID, person) {
    window.location.href="home.php?type=view&id=" + postID + "&ptype=" + posttype + "&person=" + person;
}
function sendMessage(person) {
    window.location.href="sendmessage.php?id=" + person;
}
function deleteNotif(type, id, person, nid, group) {
    window.location.href="deletenotification.php?type=" + type + "&id=" + id + "&person1=" + person + "&nid=" + nid + "&group=" + group + "&page=1";
}
function viewGroup(group, sender) {
    window.location.href="viewgroup.php?id=" + group + "&sender=" + sender;
}

</script>
</body>
</html>
