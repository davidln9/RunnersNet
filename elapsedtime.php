<?php
    class elapsedtime {
        
        public static function getElapsedTime($datein) {
            
            //echo "hi";
            try {
                date_default_timezone_set('MST');
                $date = new DateTime($datein);
                $try = 1;
                //echo "hi";
                $secondsago = date("U") - $date->format("U");
                if ($secondsago < 31540000) {
                    //echo "hi";
                    $monthsago = $secondsago/2592000;
                    // echo $monthsago;
                    if ($monthsago < 1) {
                        $daysago = $monthsago*30;
                        // echo $daysago;
			//echo "hi";
                        if ($daysago < 1) {
                          //echo $daysago;
			    $hoursago = $daysago*24;
			    //echo $hoursago;
                            if ($hoursago < 1) {
                                //echo $hoursago;
				$minsago = $hoursago*60;
                                if ($minsago < 1) {
                                    $time_elapse = "Less than a minute ago";
                                } elseif (intval($minsago) == 1) {
                                    
                                    $time_elapse = "1 minute ago";
                                } else {
                                    $time_elapse = intval($minsago)." minutes ago";
                                }
                            } elseif (intval($hoursago) == 1) {
                                $time_elapse = "1 hour ago";
                            } else {
                                $time_elapse = intval($hoursago)." hours ago";
                            }
                        } elseif (intval($daysago) == 1) {
                            $time_elapse = intval($daysago)." day ago";
                        } else {
                            $time_elapse = intval($daysago)." days ago";
                        }
                    } elseif (intval($monthsago) == 1) {
                        $time_elapse = intval($monthsago)." month ago";
                    } elseif (intval($monthsago) < 12) {
                        $time_elapse = intval($monthsago)." months ago";
                    }
                } else {
                    $time_elapse = $date->format("F j, Y");
                }
            } catch (Exception $e) {
                echo "ELAPSEDTIME LINE 95: ".$e->getMessage();
            }
            return $time_elapse;
        }
    }
    ?>
