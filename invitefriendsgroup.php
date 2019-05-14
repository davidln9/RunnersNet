<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Your Friends</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<div class="titlediv">
<?php
    include 'menu.php';
    echo "</div>";
    function mysort($a, $b) {
    
        if ($a == $b)
            return 0;
        return strcasecmp($a['firstname'],$b['firstname']);
    }
    
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $legal = false;
    $admin = false;
    
    if ($call = mysqli_query($db, "CALL GETGROUPMEMBERS($id)")) {
        while ($row = mysqli_fetch_array($call)) {
            if ($cid == $row['cryptID'] && ($row['permissions'] == 2 || $row['permissions'] == 3)) {
                if ($row['permissions'] == 3) {
                    $admin = true;
                }
                $legal = true;
            }
        }
        $call->free();
        $db->next_result();   
    } else {
        echo "grpinfo: ".mysqli_error($db);
    }
    if ($legal && $type == 1) {
        
    
        
        //echo "<div class='messagebody'>";
        $findex = 0;
        $friend = array();
        $friend = array();
        if ($call = mysqli_query($db, "CALL GetFriends('$cid')")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                if ($row['person1'] == $cid) {
                    $friend[$findex]['id'] = $row['person2'];
                } else {
                    $friend[$findex]['id'] = $row['person1'];
                }
                $findex++;
                // echo $findex;
            }
            $call->free();
            $db->next_result();
        } else {
            echo "getfriends: ".mysqli_error($db);
        }
        $temp = $findex;
        if ($call = mysqli_query($db, "CALL GETGROUPMEMBERS($id)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                $good = true;
                for ($i = 0; $i < $temp; $i++) {
                    if ($row['cryptID'] == $cid || $row['cryptID'] == $friend[$i]['id']) {
                        $good = false;
                    }
                }
                if ($good) {
                    $friend[$findex]['id'] = $row['cryptID'];
                    $findex++;
                }
            }
            $call->free();
            $db->next_result();
        } else {
            echo "getgrpmembers: ".mysqli_error($db);
        }
        $invstmt = $db->prepare("CALL GETINVITATIONS(?)");
        
        for ($i = 0; $i < $findex; $i++) {
            $friend[$i]['invited'] = -1;
            $fid = $friend[$i]['id'];
            $invstmt->bind_param("i", $fid);
            $invstmt->execute();
            $result = $invstmt->get_result();
            while ($row = $result->fetch_assoc()) {
                if ($row['id'] == $id && $row['type'] == 0) {
                    $friend[$i]['invited'] = $row['status'];
                } 
            }
            $db->next_result();
        }
        echo "<div class='friendresults'>";
    
        // echo "hi";
        //echo "feed";
        $basicinfo = $db->prepare("CALL GETBASICINFO(?)");
        for ($f = 0; $f < $findex; $f++) {
            $thisfriend = $friend[$f]['id'];
            $basicinfo->bind_param("i", $thisfriend);
            $basicinfo->execute();
            $result = $basicinfo->get_result();
            while ($row = $result->fetch_assoc()) {
                //echo "name";
                $friend[$f]['firstname'] = trim($row['firstname']);
                $friend[$f]['lastname'] = trim($row['lastname']);
                $friend[$f]['pic'] = trim($row['img_filepath']);
                $friend[$f]['id'] = $row['cryptID'];
            }
            $db->next_result();                
        }
    
        // $friend = $friend;
        usort($friend, "mysort");
    
        for ($i = 0; $i < $findex; $i++) {
        
            $fid = $friend[$i]['id'];
        
            echo "<div class='messagefriends'>";
            echo "<div class='displaypic'>";
            echo profilepic::getPic(30, $friend[$i]['pic']);
            echo "</div>"; //closes picresults
            echo "<div class='messagename'>";
            $theID = $friend[$i]['id'];
            echo "<a href='viewprofile.php?id=$theID'>".$friend[$i]['firstname']." ".$friend[$i]['lastname']."</a>";
            if ($friend[$i]['invited'] == -1)
                echo "<button id='btnOptions$i' onclick='sendInvitation($fid,$i,$id,0)'>Invite</button>";
            elseif ($friend[$i]['invited'] == 0)
                echo "<button id='undoButton$i' onclick='unsendInvitation($fid,$i,$id,0)'>Uninvite</button>";
            elseif($friend[$i]['invited'] == 1)
                echo "<button id='remove$i' onclick='remove($fid,$i,$id)'>Remove</button>";
            elseif($friend[$i]['invited'] == 2)
                echo "<button id='undoRemove$i' onclick='undoRemove($fid,$i,$id)'>Undo Remove</button>";
            // echo $fid;
            echo "</div>"; //closes nameresults
            echo "</div>"; //closes messagefriends
        
        }
        echo "<button onclick='goBack($id)'>Back</button>";
        echo "</div>"; //close resultfeed
        
    } elseif ($admin && $type == 2) {
        
        $members = array();
        $mi = 0;
        if ($call = mysqli_query($db, "CALL GETGROUPMEMBERS($id)")) {
            
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
               
                if ($row['cryptID'] != $cid && $row['permissions'] < 9) {
                    $members[$mi]['id'] = $row['cryptID'];
                    $members[$mi]['mod'] = 0;
                    $members[$mi]['perm'] = $row['permissions'];
                    $mi++;
                }
            }
            $call->free();
            $db->next_result();
        } else {
            echo "GRPMEMBERS: ".mysqli_error($db);
        }
        $basicinfo = $db->prepare("CALL GETBASICINFO(?)");
        $invitestmt = $db->prepare("CALL GETINVITATIONS(?)");
        for ($i = 0; $i < $mi; $i++) {
            $memID = $members[$i]['id'];
            $basicinfo->bind_param("i", $memID);
            $basicinfo->execute();
            $result = $basicinfo->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $members[$i]['firstname'] = $row['firstname'];
                $members[$i]['lastname'] = $row['lastname'];
                $members[$i]['pic'] = $row['img_filepath'];
            }
            $db->next_result();
            $invitestmt->bind_param("i", $memID);
            $invitestmt->execute();
            $result = $invitestmt->get_result();
            $members[$i]['mod'] = -1;
            while ($row = $result->fetch_assoc()) {
                if ($row['type'] == 2) {
                    $members[$i]['mod'] = $row['status'];
                } 
            }
            $db->next_result();
            
        }    
        usort($members, "mysort");
        echo "<div class='friendresults'>";
        for ($i = 0; $i < $mi; $i++) {
            
            $memID = $members[$i]['id'];
            echo "<div class='messagefriends'>";
            echo "<div class='displaypic'>";
            echo profilepic::getPic(30, $members[$i]['pic']);
            echo "</div>"; //closes picresults
            echo "<div class='messagename'>";
            $theID = $friend[$i]['id'];
            echo "<a href='viewprofile.php?id=$memID'>".$members[$i]['firstname']." ".$members[$i]['lastname']."</a>";
            if ($members[$i]['mod'] == -1)
                echo "<button id='btnOptions$i' onclick='sendInvitation($memID,$i,$id,2)'>Appoint</button>";
            elseif ($members[$i]['mod'] == 0)
                echo "<button id='undoButton$i' onclick='unsendInvitation($memID,$i,$id,2)'>Undo Appoint</button>";
            elseif ($members[$i]['mod'] == 1)
                echo "<button id='btnRelieve$i' onclick='removeModerator($memID,$i,$id)'>Relieve</button>";
            elseif ($members[$i]['mod'] == 2)
                echo "<button id='undoFire$i' onclick='undoFire($memID,$i,$id)'>Undo Relieve</button>";
            echo "</div></div>";
        }
        echo "<button onclick='goBack($id)'>Back</button>";
    }
        ?>

        <script>
            //var xmlhttp;
            function sendInvitation(friend, comp, id, type) {
                var button = document.getElementById("btnOptions" + comp);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "invite.php");
                var params = "action=0&id="+id+"&friend="+friend+"&type="+type;
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        button.innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.send(params);
                button.id="undoButton"+comp;
                button.onclick = function(){unsendInvitation(friend, comp, id, type);}
            }
            function unsendInvitation(friend, comp, id, type) {
                var button = document.getElementById("undoButton" + comp);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "invite.php?");
                var params = "action=" + 1 + "&type=" + type + "&friend=" + friend + "&id=" + id;
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        button.innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.send(params);
                button.id = "btnOptions" + comp;
                button.onclick = function(){sendInvitation(friend, comp, id, type);}
                // window.location.href="invite.php?action=" + 1 + "&type=" + 0 + "&friend=" + friend + "&id=" + id;
            }
            
            function removeModerator(memid,comp,id) {
                var button = document.getElementById("btnRelieve" + comp);
                var xmlhttp = new XMLHttpRequest();
                var url = "firemod.php";
                var params = "id="+id+"&user=" + memid+"&type=1";
                xmlhttp.open("POST", url, true);

                //Send the proper header information along with the request
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        button.innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.send(params);
                button.onclick = function(){undoFire(memid,comp,id);}
                button.id = "undoFire"+comp;
            }
            function undoFire(memid,comp,id) {
                var button = document.getElementById("undoFire"+comp);
                var xmlhttp = new XMLHttpRequest();
                var url = "firemod.php";
                var params = "id="+id+"&user="+memid+"&type=2";
                xmlhttp.open("POST", url, true);
                
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        button.innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.send(params);
                button.onclick = function(){removeModerator(memid,comp,id);}
                button.id = "btnRelieve" + comp;
            }
            function remove(fid,comp,group) {
                var button = document.getElementById("remove" + comp);
                var xmlhttp = new XMLHttpRequest();
                var url = "firemod.php";
                var params = "id="+group+"&user="+fid+"&type=3";
                xmlhttp.open("POST", url, true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        button.innerHTML = xmlhttp.responseText;
                    }
                }
                
                xmlhttp.send(params);
                button.onclick = function(){undoRemove(fid,comp,group);}
                button.id="undoRemove"+comp;
            }
            function undoRemove(fid,comp,group) {
                var button = document.getElementById("undoRemove"+comp);
                var xmlhttp = new XMLHttpRequest();
                var url = "firemod.php";
                var params = "id="+group+"&user="+fid+"&type=4";
                xmlhttp.open("POST", url, true);
                
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        button.innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.send(params);
                button.onclick = function(){remove(fid,comp,group);}
                button.id="remove"+comp;
            }
            function goBack(groupid) {
                window.location.href="admintools.php?id="+groupid;
            }
    </script> 
    </body>
</html>

