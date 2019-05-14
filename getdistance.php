<?php
    include 'sessioncheck.php';
    class distance {
        
        public static function getdistance($store, $index) {
            
            if ($call=mysqli_query($db, "CALL getDistance('$uname')")) {
                $intensity;
                $fields = 0;
                while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                    $fields = mysqli_num_fields($call);
                    for ($si = 0; $si < $fields; $si++) {
                        if ($store[$index])
                        $store[$index][$si] = $row[$si];
                    }
                    
                    $index++;
                    
                }
                return array($store,$index);
                
            } else {
                echo "<strong>Error</strong>";
            }
        }
    }
    ?>

