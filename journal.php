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
<script>
    var dist = 0.0;
    var string1 = "";
    var count = 0;
    function clickDiv(m, d) {
        document.getElementById("journal" + m).style.backgroundColor = "orange";
        document.getElementById("journal" + m).onclick = function() {unclickDiv(m,d);}
        if (dist == 0.0) {
            string1 = document.getElementById("totalDiv").innerHTML;
            count++;
        }
        dist+=d;
        document.getElementById("totalDiv").innerHTML = "<p>Selected: " + dist + "</p>"
    }
    function unclickDiv(m, d) {
        document.getElementById("journal" + m).style.backgroundColor = "white";
        document.getElementById("journal" + m).onclick = function() {clickDiv(m,d);}
        dist-=d;
        if (dist > 0.0) {
            document.getElementById("totalDiv").innerHTML = "<p>Selected: " + dist + "</p>";
        } else {
            dist = 0.0;
            document.getElementById("totalDiv").innerHTML = string1;
        } 
    }
</script>
<script src="node_modules/chart.js/dist/Chart.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="titlediv">
<?php
    function datesort($a, $b) {
        if ($a == $b)
            return 0;
        return strtotime($a['date']) > strtotime($b['date']);
    }
    include 'menu.php';
    $mileage = 0;
    $weekmil = 0;
    $monthmil=0;
    $yearmil=0;
    $index = 0;
    $diststmt = $db->prepare("CALL GETDISTANCE(?)");
    $racestmt = $db->prepare("CALL GETRACES(?)");
    $speedstmt = $db->prepare("CALL GETSPEED(?)");
    $store = array();
    $basic = array();
   	$months['miles'] = array(); 
    $months['name'] = array();
    include "feedloader.php";
    $action = new FeedLoader();
    
    //load the user's posts into store
    list($store, $index) = $action->loadRuns($store, $diststmt, $racestmt, $speedstmt, $index, $db, $cid);
    unset($action);
    
    list($yearmil,$monthmil,$weekmil) = mileage::getmileages($store);
    
    usort($store, "datesort");
    
    // $years = mileage::divideIntoYears($store);
    
    
    
    echo "</div>";
    echo "<div class='milesdiv' id='milesdiv'>";
    echo "<div id='totalDiv'>Total Miles<br>This Year: ".$yearmil."&nbsp This Month: ".$monthmil."&nbsp This Week: ".$weekmil."</div>";
    echo "</div>";
    ?>
</div>
</header>
<body>
	<div class='journalfeed'>
<div class="chart-container" style="position: relative; height:600px; width:450px;background:white;">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
<?php
    $miles = 0;
    $yearmiles = 0;
    echo "<div class='regposts'>";
    for ($i = count($store) - 1; $i >= 0; $i--) {
        
        try {
            $date = new DateTime($store[$i]['date']);
            $future = new DateTime($store[$i+1]['date']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $toDisplay = false;
        if ($date->format("Y") == date("Y")) {
            $toDisplay = true;
        }
        // echo "<p>".$date->format("Y").":</p>";
            
        $type = $store[$i]['type'];
        
        // if ($j == 0) {
//             echo "<p>".$date->format("F").":</p>";
//         }

        
        if ($date->format("m") < $future->format("m") || $date->format("Y") < $future->format("Y")) {
            echo "<br>Total for ".$future->format("F").": ".$monthmiles."<br><br>";
            if ($date->format("Y") == $future->format("Y"))
                echo $date->format("F");
				array_push($months['miles'], $monthmiles);
				array_push($months['name'], $future->format("F")." ".$future->format("Y"));
				$monthmiles = 0;
			}	
        if ($date->format("Y") < $future->format("Y")) {
            echo "Total (".$future->format("Y")."): ".$yearmiles."<br>";
            $yearmiles = 0;
            echo $date->format("Y")."<br>";
            echo $date->format("F");
            
        }
                
        if ($i == count($store) - 1 && $toDisplay) { 
            echo $date->format("Y")."<br>"; 
            echo $date->format("F"); 
        }
        $dist = $store[$i]['distance'];
        echo "<div class='regpostfloater' id='journal$i' onclick='clickDiv($i, $dist)'>";
        switch ($type) {
            case 0:
            $type = "Distance Run";
            break;
            case 1:
            $type = "Speed Workout";
            break;
            case 2:
            $type = "Race";
            break;
        }
        echo "<p>".$store[$i]['date']." -- ".$type." -- ".$store[$i]['distance']."</p>";
        $miles+=$store[$i]['distance'];
        $yearmiles+=$store[$i]['distance'];
        $monthmiles+=$store[$i]['distance'];
        
    echo "</div>";
    }
    if (count($store) > 0) {
        echo "Total (".$date->format("Y")."): ".$yearmiles."<br>";
    }
    echo "</div>";
    //unset($years);
    unset($date);
    unset($future);
    ?>
</div>
<script type="text/javascript">
  var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
//        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		<?php
			echo "labels: [";
			for ($i = sizeof($months['name']) - 1; $i > 0; $i--) {
				echo "'".$months['name'][$i]."'";
				if ($i > 1) {
					echo ",";
				}
			}
			echo "],";
		?>
		
		datasets: [{
            label: 'Miles',
//            data: [12, 19, 3, 5, 2, 3],
			<?php
	  			echo "data: [";
				for ($i = sizeof($months['miles']) - 1; $i > 0; $i--) {
					echo $months['miles'][$i];
					if ($i > 1) {
						echo ",";
					}
				}
				echo "],";
			?>		
			backgroundColor: [
//                'rgba(255, 99, 132, 0.2)',
//                'rgba(54, 162, 235, 0.2)',
//                'rgba(255, 206, 86, 0.2)',
//                'rgba(75, 192, 192, 0.2)',
//                'rgba(153, 102, 255, 0.2)',
//                'rgba(255, 159, 64, 0.2)'
			<?php
				for ($i = 0; $i < sizeof($months['name']); $i++) {
					echo "'rgba(255, 99, 132, 0.2)'";
					if ($i < sizeof($months['name']) - 1) {
						echo ",";
					}
				}
			?>
			],
            borderColor: [
 //               'rgba(255, 99, 132, 1)',
 //               'rgba(54, 162, 235, 1)',
 //               'rgba(255, 206, 86, 1)',
 //               'rgba(75, 192, 192, 1)',
 //               'rgba(153, 102, 255, 1)',
 //               'rgba(255, 159, 64, 1)'
			<?php
				for ($i = 0; $i < sizeof($months['name']); $i++) {
					echo "'rgba(255, 99, 132, 1)'";	
					if ($i < sizeof($months['name']) - 1) {
						echo ",";
					}
				}
			?>
			],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});	
  </script>
</body>
</html>
