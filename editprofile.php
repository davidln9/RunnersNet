<?php
    include 'sessioncheck.php';
    include_once 'profilepicture.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Edit Profile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
    include 'menu.php';
    
    $action = isset($_GET['id']) ? $_GET['id'] : null;
    $group = isset($_GET['group']) ? $_GET['group'] : null;
    $error = isset($_GET['error']) ? $_GET['error'] : 100;
    $msg = isset($_GET['msg']) ? $_GET['msg'] : null;
    ?>
</div>
</header>
<script>
    function addShoes() {
        window.location.href='addshoes.php';
    }
</script>
<body>
<center>
    <?php
    if ($action == 1) {
        echo "<div class='editpic'>";
        if ($error == 7) {
            echo "<p><strong>Image Too Large</strong></p>";
        } elseif ($error == 0) {
            echo "<p><strong>File is not an Image</strong></p>";
        } elseif ($error == 4) {
            echo "<p><strong>Only JPG, PNG, and GIFs allowed</strong></p>";
        } elseif ($msg == 5) {
            echo "<p><strong>Page Loads Updated</strong></p>";
        }
    ?>
<p>Profile Picture:</p><br>
<?php
    echo profilepic::getProfilePic(150);
    ?>
<br>
<form id="infoform" name="infoform" method="post" action="upload.php" enctype="multipart/form-data">

<input id="FileUpload" type="file" name="ImageUpload">
<input type="submit" value="Upload Image" name="btnSubmitPhoto" id="btnSubmitPhoto">
</form>
</div>
<div class="editbio">
<p>Bio:</p><br>
<form id="editbio" method="post" action="accountchanges.php" name="editbio">
<?php
    echo "<textarea id='thebio' name='thebio' class='bio' rows='8' cols='25'>".$_SESSION['biography']."</textarea>";
    ?>
    <input type="hidden" value="profile" id="action" name="action">
<input type="submit" value="Save Bio" id="btnChangeBio" name="btnChangeBio">
</form>
</div>
<div class="editlimits">
<p>Settings:</p><br>
    <?php
        $limstmt = $db->prepare("CALL GETLIMITS(?)");
        $limstmt->bind_param("i", $cid);
        $limstmt->execute();
        $result = $limstmt->get_result();
        $hasLimit = false;
        $db->next_result();
        while ($row = $result->fetch_assoc()) {
            $hasLimit = true;
            $dist10 = $row['distanceLoad'];
            $distLimit = $row['distanceEntries'];
            $speed10 = $row['speedLoad'];
            $speedLimit = $row['speedEntries'];
            $race10 = $row['raceLoad'];
            $raceLimit = $row['raceEntries'];
            $pagePost10 = $row['pagePostLoad'];
            $pagePostLimit = $row['pagePostEntries'];
            $grpPagePost10 = $row['grpPagePostLoad'];
            $grpPagePostLimit = $row['grpPagePostEntries'];
            $post10 = $row['postLoad'];
            $postLimit = $row['postEntries'];
            $grpPost10 = $row['grpPostsLoad'];
            $grpPostLimit = $row['grpPostEntries'];
        }
        if ($hasLimit) {
            if ($dist10 == 1) {
                $dist10 = true;
            } else {
                $dist10 = false;
            }

            if ($speed10 == 1)
                $speed10 = true;
            else
                $speed10 = false;

            if ($race10 == 1)
                $race10 = true;
            else
                $race10 = false;

            if ($pagePost10 == 1)
                $pagePost10 = true;
            else
                $pagePost10 = false;

            if ($grpPagePost10 == 1)
                $grpPagePost10 = true;
            else
                $grpPagePost10 = false;

            if ($grpPost10 == 1)
                $grpPost10 = true;
            else
                $grpPost10 = false;
            
            echo "<form id='limitform' name='limitform' method='post' action='limithandler.php'>";        
            echo "Distance Runs per page:<br>";
            echo "<select name='optDistance'>";
            if ($distLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($distLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($distLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($distLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>"; 
            if ($distLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($distLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($distLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>"; 
            if ($distLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($distLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($distLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($distLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";           
            echo "</select>";
            echo "<br>Speed Workouts per Page:<br>";
            echo "<select name='optSpeed'>";
            if ($speedLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($speedLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($speedLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($speedLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>";
            if ($speedLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($speedLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($speedLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>";
            if ($speedLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($speedLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($speedLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($speedLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";

            echo "</select>";                     
            echo "<br>Race Entries per Page:<br>";
            echo "<select name='optRaces'>";
            if ($raceLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($raceLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($raceLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($raceLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>";
            if ($raceLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($raceLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($raceLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>";
            if ($raceLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($raceLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($raceLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($raceLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";

            echo "</select>";

            echo "<br>Regular Posts per Page:<br>";
            echo "<select name='optPosts'>";
            if ($postLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($postLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($postLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($postLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>";
            if ($postLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($postLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($postLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>";
            if ($postLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($postLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($postLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($postLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";

            echo "</select>";




            echo "<br>Page Posts loads per Page:<br>";
            echo "<select name='optPagePosts'>";
            if ($pagePostLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($pagePostLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($pagePostLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($pagePostLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>";
            if ($pagePostLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($pagePostLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($pagePostLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>";
            if ($pagePostLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($pagePostLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($pagePostLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($pagePostLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";

            echo "</select>"; 

            echo "<br>Group Posts per Page:<br>";
            echo "<select name='optGrpPosts'>";
            if ($grpPostLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($grpPostLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($grpPostLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($grpPostLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>";
            if ($grpPostLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($grpPostLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($grpPostLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>";
            if ($grpPostLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($grpPostLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($grpPostLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($grpPostLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";

            echo "</select>";

             echo "<br>Group Page Post Loads per Page:<br>";
            echo "<select name='optGrpPagePost'>";
            if ($grpPagePostLimit == 0)
                echo "<option value='0' selected='selected'>0</option>";
            else
                echo "<option value='0'>0</option>";
            if ($grpPagePostLimit == 10)
                echo "<option value='10' selected='selected'>10</option>";
            else
                echo "<option value='10'>10</option>";
            if ($grpPagePostLimit == 20)
                echo "<option value='20' selected='selected'>20</option>";
            else
                echo "<option value='20'>20</option>";
            if ($grpPagePostLimit == 30)
                echo "<option value='30' selected='selected'>30</option>";
            else
                echo "<option value='30'>30</option>";
            if ($grpPagePostLimit == 40)
                echo "<option value='40' selected='selected'>40</option>";
            else
                echo "<option value='40'>40</option>";
            if ($grpPagePostLimit == 50)
                echo "<option value='50' selected='selected'>50</option>";
            else
                echo "<option value='50'>50</option>";
            if ($grpPagePostLimit == 60)
                echo "<option value='60' selected='selected'>60</option>";
            else
                echo "<option value='60'>60</option>";
            if ($grpPagePostLimit == 70)
                echo "<option value='70' selected='selected'>70</option>";
            else
                echo "<option value='70'>70</option>";
            if ($grpPagePostLimit == 80)
                echo "<option value='80' selected='selected'>80</option>";
            else
                echo "<option value='80'>80</option>";
            if ($grpPagePostLimit == 90)
                echo "<option value='90' selected='selected'>90</option>";
            else
                echo "<option value='90'>90</option>";
            if ($grpPagePostLimit == 100)
                echo "<option value='100' selected='selected'>100</option>";
            else
                echo "<option value='100'>100</option>";

            echo "</select><br>";

            echo "<input type='submit' name='btnSubmitLimits' id='btnSubmitLimits'>";
            echo "</form>";             

        }
?>
</div>
<?php
    
    $shoes = array();
    $shoeindex = 0;
    echo "<div class='editlimits'>";
    echo "<p>Running Shoes:</p>";
    if ($call = mysqli_query($db, "CALL GETSHOES($cid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
            $shoes[$shoeindex]['id'] = $row['shoeID'];
            $shoes[$shoeindex]['brand'] = $row['Make'];
            $shoes[$shoeindex]['name'] = $row['Model'];
            $shoes[$shoeindex]['year'] = $row['year'];
            $shoeindex++;
        }
        $call->free();
        $db->next_result();
    }
    $shoediststmt = $db->prepare("CALL GETSHOEDISTANCE(?,?)");
    $shoediststmt->bind_param('ii', $cid, $shoeid); 
    for ($si = 0; $si < $shoeindex; $si++) {
        //echo "hi";
        $miles = 0;
        $shoeid = $shoes[$si]['id'];
       // echo $shoeid;
        //$shoediststmt->bind_param('ii', $cid, $shoeid);
        $shoediststmt->execute();
        
        $result = $shoediststmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $miles+= $row['distance'];
        }
        $db->next_result();
        
        echo $shoes[$si]['brand']." ".$shoes[$si]['name'].": ".$miles." miles";
        echo "<br>";
    }
    echo "<button onclick='addShoes()'>Add a pair</button>";
    echo "</div>";
} elseif ($action == 2) {
    $groupinfo = array();
    if ($call = mysqli_query($db, "CALL GETGROUPINFO($group)")) {
        while ($row = mysqli_fetch_array($call)) {
            $groupinfo['name'] = $row['name'];
            $groupinfo['type'] = $row['type'];
            $groupinfo['policy'] = $row['policy'];
            $groupinfo['admin'] = $row['admin'];
            $groupinfo['location'] = $row['location'];
            $groupinfo['pagepolicy'] = $row['pagepolicy'];
            $groupinfo['img'] = $row['img_filepath'];
            $groupinfo['description'] = trim($row['description']);
        }
        $call->free();
        $db->next_result();
    } else {
        echo "getgroupinfo: ".mysqli_error($db);
    }
    
    if ($cid != $groupinfo['admin']) {
        echo "<p>Error: Unauthorized Access</p>";
    } else {
        echo "<div class='editpic'>";
        if ($error == 7) {
            echo "<p><strong>Image Too Large</strong></p>";
        } elseif ($error == 0) {
            echo "<p><strong>File is not an Image</strong></p>";
        } elseif ($error == 4) {
            echo "<p><strong>Only JPG, PNG, and GIF images are allowed</strong></p>";
        }
        ?>
        
        <p>Group Profile Picture:</p><br>
        <?php
            echo profilepic::getPic(150, $groupinfo['img']);
            ?>
        <br>
        <form id="infoform" name="infoform" method="post" action="upload.php" enctype="multipart/form-data">

        <input id="FileUpload" type="file" name="ImageUpload">
        <input type="submit" value="Upload Image" name="btnEditGroupPic" id="btnEditGroupPic">
        <input type="hidden" value='<?php echo $group; ?>' name="groupID" id="groupID"> 
        </form>
        </div>
        <div class="editbio">
        <p>Bio:</p><br>
        <form id="editbio" method="post" action="accountchanges.php" name="editbio">
        <?php
            echo "<textarea id='thebio' name='thebio' class='bio' rows='8' cols='25'>".$groupinfo['description']."</textarea>";
            ?>
            <input type="hidden" value="group" id="action" name="action">
            <input type="hidden" value='<?php echo $group; ?>' id="group" name="group">
        <input type="submit" value="Save Bio" id="btnChangeBio" name="btnChangeBio">
        </form>
        </div>
        
        <?php
    }
}
?>
</center>
</body>
</html>

