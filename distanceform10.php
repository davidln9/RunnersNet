<?php
    include 'sessioncheck.php';
    ?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
<title>Race Entry</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    include 'menu.php';
    ?>
</div>
</header>
<body>
<center>
<form id="typeform" name="typeform" method="post" action="getdistanceentry.php">
<div class="distancediv">
<p>What pair of shoes did you wear?<p><br>
<?php
    $shoeindex = 0;
    $shoes = array();
    if ($call = mysqli_query($db, "CALL GETSHOES($cid)")) {
        while ($row = mysqli_fetch_array($call, MYSQLI_ASSOC)) {
            $shoes[$shoeindex]['make'] = $row['Make'];
            $shoes[$shoeindex]['name'] = $row['Model'];
            $shoes[$shoeindex]['year'] = $row['Year'];
            $shoes[$shoeindex]['id'] = $row['shoeID'];
            $shoeindex++;
        }
        $call->free();
        $db->next_result();
    }
    echo "<form id='shoeform' name='shoeform' method='post' action='getdistanceentry.php'>";
    
    echo "<select name='shoeselection'>";
    echo "<option value='0' selected>Select a shoe</option>";
    for ($i = 0; $i < $shoeindex; $i++) {
        $brand = $shoes[$i]['make'];
        $name = $shoes[$i]['name'];
        $sid = $shoes[$i]['id'];
        echo "<option value='$sid'>$brand $name</option>";
    }
    echo "</select>";    
?>
<input type="submit" value="next" name="btnSubmitShoe" id="btnSubmitShoe">
</form>
</div>
</center>
</body>
</html>
