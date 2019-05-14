<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
<link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Search Results</title>
<meta charset="UTF-8">
<?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    
    function mysort($a, $b) {
        if ($a == $b)
            return 0;
        elseif ($a['type'] == $b['type'])
            return strcasecmp($a, $b);
        else
            return $a['type'] > $b['type'];
    }
    
    if (isset($_POST['btnSubmitSearch'])) {
        $search = $_POST['search'];
        
        $names = array();
        $info = array();
        $index = 0;
        if ($call=mysqli_query($db, "CALL GETPEOPLE")) {
            while ($row=mysqli_fetch_array($call, MYSQLI_BOTH)) {
                
                $info[$index]['type'] = 1; //1 is for person, 2 is for group
                $info[$index]['fname'] = $row['firstname'];
                $info[$index]['lname'] = $row['lastname'];
                $info[$index]['id'] = $row['cryptID'];
                $info[$index]['img'] = $row['img_filepath'];
                $index++;
            }
            $call->free();
            $db->next_result();
        } else {
            echo "getpeople: ".mysqli_error($db);
        }
        $gi = 0;
        if ($call = mysqli_query($db, "CALL GETGROUPS")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                
                $info[$index]['type'] = 2;
                $info[$index]['name'] = $row['name'];
                $info[$index]['location'] = $row['location'];
                $info[$index]['id'] = $row['id'];
                $info[$index]['img'] = $row['img_filepath'];
                $index++;
                $gi++;
            }
        } else {
            echo "getgroups: ".mysqli_error($db);
        }
        
    }
    ?>
</div>
</header>
<body>
<?php
    
    $result = 0;
    $people = false;
    $groups = false;
    $results = array();
    //picture first name last name search results
    echo "<div class = 'resultfeed'>";
    include_once 'profilepicture.php';
    
    for ($i=0; $i<$index; $i++) {
        if ($info[$i]['type'] == 1) {
            if (strcasecmp($search,$info[$i]['fname']) == 0 || strcasecmp($search,$info[$i]['lname']) == 0 || strcasecmp($search,$info[$i]['fname']." ".$info[$i]['lname']) == 0) {

            $results[$result] = $info[$i];
            $result++;
            $people = true;
            }
        } elseif ($info[$i]['type'] == 2) {
            if (strcasecmp($search,$info[$i]['name']) == 0) {
                $results[$result] = $info[$i];
                $result++;
                $groups = true;
            }
        }
    }
    if ($result == 0) {
        echo "<div class='searchresults'>";
        echo "<p>No people or groups found</p>";
        echo "</div>";
    } else {
        usort($results, "mysort");
        $i = 0;
        if ($people) {
            echo "<p>People:</p>";            
            
            while ($results[$i]['type'] == 1) {
                echo "<div class='searchresults'>";

                if ($results[$i]['img'] != NULL) {
                    echo "<div class='picresults'>";
                    echo profilepic::getPic(50,$results[$i]['img']);
                    echo "</div>";
                }
                echo "<div class='nameresults'>";
                if ($results[$i]['id'] == $cid) {
                    echo "<p><a href='profilepage.php'>".$results[$i]['fname']." ".$results[$i]['lname']."</a></p>";
                    echo "</div></div>";
                } else {
                    $id = $results[$i]['id'];
                    echo "<p><a href='viewprofile.php?id=$id'>".$results[$i]['fname']." ".$results[$i]['lname']."</a></p>";
                    echo "</div></div>";
                }
                $i++;
            }
        }
        if ($groups) {
            echo "<p>Groups:</p>";
            
            while ($results[$i]['type'] == 2) {
                echo "<div class='searchresults'>";

                if ($results[$i]['img'] != NULL) {
                    echo "<div class='picresults'>";
                    echo profilepic::getPic(50,$results[$i]['img']);
                    echo "</div>";
                }
                echo "<div class='nameresults'>";
                $id = $results[$i]['id'];
                echo "<p><a href='viewgroup.php?id=$id'>".$results[$i]['name']."</a></p>";
                echo "</div></div>";
                $i++;
            }
        }
        
    }
    
    unset($results);
    unset($row);
    unset($info);
    
    echo "</div>";
    ?>
</body>
</html>

