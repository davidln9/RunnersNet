<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    include 'mileage.php';
    ?>
<!DOCTYPE html>
<html>

<header>
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
<link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<title>View Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php   
    include 'menu.php';
    
    $memberindex = 0; //groups this user is in
    $adminindex = 0; //groups this user administrates
    $modindex = 0;  //groups this user is a moderator in
    $member = array();
    $administrator = array();
    $moderator = array();
    
    //get the groups this user is associated with
    if ($call = mysqli_query($db, "CALL GETMYGROUPS($cid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            
            if ($row['permissions'] == 3) {
                $administrator[$adminindex]['groupID'] = $row['groupID'];
                $adminindex++;
            } elseif ($row['permissions'] == 2) {
                $moderator[$modindex]['groupID'] = $row['groupID'];
                $modindex++;
            } elseif ($row['permissions'] == 1 || $row['permissions'] == 0) {
                $member[$memberindex]['groupID'] = $row['groupID'];
                $memberindex++;
            }
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getmygroups: ".mysqli_error($db);
    }
    
    ?>
</div>
</header>
<body>

<?php
echo "<div class='notfriends'>";
if ($memberindex == 0 && $modindex == 0 && $adminindex == 0) {
    echo "<div class='regpostfloater'>";
    echo "<p>You're not in any groups</p>";
    echo "</div>";
    
}
$adminGroup = array();
$groupstmt = $db->prepare("CALL GETGROUPINFO(?)");
if ($adminindex > 0) {
    
    echo "<p>Administrator:</p>";
    for ($i = 0; $i < $adminindex; $i++) {
        
        $groupid = $administrator[$i]['groupID'];
        $groupstmt->bind_param("i", $groupid);
        $groupstmt->execute();
        $result = $groupstmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $adminGroup['name'] = $row['name'];
            $adminGroup['type'] = $row['type'];
            $adminGroup['policy'] = $row['policy'];
            $adminGroup['admin'] = $row['admin'];
            $adminGroup['location'] = $row['location'];
            $adminGroup['pagepolicy'] = $row['pagepolicy'];
            $adminGroup['img'] = $row['img_filepath'];
            $adminGroup['description'] = trim($row['description']);
        }
        
        $db->next_result();
        
        
        echo "<div class='regpostfloater'>";
        echo "<div class='picresults'>";
        echo profilepic::getPic(50,$adminGroup['img']);
        echo "</div>";
        echo "<div class='nameresults'>";
        echo "<a href=viewgroup.php?id=$groupid>".$adminGroup['name']."</a>";
        echo "</div>";
        echo "</div>";
    }
}
if ($modindex > 0) {
    
    echo "<p>Moderator:</p>";
    for ($i = 0; $i < $modindex; $i++) {
        
        $groupid = $moderator[$i]['groupID'];
        $groupstmt->bind_param("i", $groupid);
        $groupstmt->execute();
        $result = $groupstmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $adminGroup['name'] = $row['name'];
            $adminGroup['type'] = $row['type'];
            $adminGroup['policy'] = $row['policy'];
            $adminGroup['admin'] = $row['admin'];
            $adminGroup['location'] = $row['location'];
            $adminGroup['pagepolicy'] = $row['pagepolicy'];
            $adminGroup['img'] = $row['img_filepath'];
            $adminGroup['description'] = trim($row['description']);
        }
        
        $db->next_result();
        
        echo "<div class='regpostfloater'>";
        echo "<div class='picresults'>";
        echo profilepic::getPic(50,$adminGroup['img']);
        echo "</div>";
        echo "<div class='nameresults'>";
        echo "<a href=viewgroup.php?id=$groupid>".$adminGroup['name']."</a>";
        echo "</div>";
        echo "</div>";
    }
}
if ($memberindex > 0) {
    
    echo "<p>Member:</p>";
    for ($i = 0; $i < $memberindex; $i++) {
        
        $groupid = $member[$i]['groupID'];
        $groupstmt->bind_param("i", $groupid);
        $groupstmt->execute();
        $result = $groupstmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $adminGroup['name'] = $row['name'];
            $adminGroup['type'] = $row['type'];
            $adminGroup['policy'] = $row['policy'];
            $adminGroup['admin'] = $row['admin'];
            $adminGroup['location'] = $row['location'];
            $adminGroup['pagepolicy'] = $row['pagepolicy'];
            $adminGroup['img'] = $row['img_filepath'];
            $adminGroup['description'] = trim($row['description']);
        }
        
        $db->next_result();
        
        echo "<div class='regpostfloater'>";
        echo "<div class='picresults'>";
        echo profilepic::getPic(50,$adminGroup['img']);
        echo "</div>";
        echo "<div class='nameresults'>";
        echo "<a href=viewgroup.php?id=$groupid>".$adminGroup['name']."</a>";
        echo "</div>";
        echo "</div>";
    }
}
echo "<button id='btnCreateGroup' onclick='createGroup()'>Create Group</button>";
echo "</div>";
?>
<script>
    function createGroup() {
        window.location.href='groupsetup1.php';
    }
</script>
</body>
</html>
