<?php
    include 'sessioncheck.php';
    class races {
        
        public static function getraces {
            
           	include 'secure.php'; 
            $mileage = 0;
            $weekmil = 0;
            $monthmil=0;
            $yearmil=0;
            $index = 0;
            $retval = array();
			$db = mysqli_connect($server,$user,$password,$database) or die("no connection");
			$storerace = array();
            if ($call=mysqli_query($db, "CALL getRace('$uname')")) {
                while ($row=mysqli_fetch_array($call, MYSQLI_NUM)) {
                $fields = mysqli_num_fields($call);
                for ($f = 0; $f < $fields; $f++) {
                $colvar;
                switch ($f) {
                case 0:
                $colvar="username";
                break;
                case 1:
                $colvar="id";
                break;
                case 2:
                $colvar="distance";
                break;
                case 3:
                $colvar="date";
                break;
                case 4:
                $colvar="time";
                break;
                case 5:
                $colvar="location";
                break;
                case 6:
                $colvar="racename";
                break;
                case 7:
                $colvar="relay";
                break;
                case 8:
                $colvar="runtime";
                break;
                case 9:
                $colvar="pace";
                break;
                case 10:
                $colvar="journal";
                break;
                default:
                $colvar="error";
                break;
                }
                $storerace[$index][$f] = $row[$f];
                }
                $index++;
                }
                $call->free();
                $db->next_result();
//                $call->free();
//                $db->next_result();
                $val = array($storerace,$index);
                return $val;
                }

        }
    }
    ?>

