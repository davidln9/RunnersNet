<?php
    class mileage {
    
        public static function getmileages($store) {
            $yearmil = 0;
            $monthmil = 0;
            $weekmil = 0;
            $month = 0;
            for ($i = 0; $i < count($store); $i++) {
                
                if (intval($store[$i]['type']) == 0 || intval($store[$i]['type']) == 1 || intval($store[$i]['type']) == 2)
                {
                    try {
                        date_default_timezone_set('MST');
                        $date = new DateTime($store[$i]['date']);
                    } catch (Exception $e) {
                        echo "getmileages ".$e->getMessage();
                    }
                    
                    if (intval($date->format("Y")) == intval(date("Y"))) {
                        $yearmil+=floatval($store[$i]['distance']);
                    }
                    if ($date->format("m") == intval(date("m")) && $date->format("Y") == date("Y")) {
                        $monthmil+=floatval($store[$i]['distance']);
                    }
                    if (intval($date->format("W")) == intval(date("W")) && $date->format("Y") == date("Y")) {
                        $weekmil += floatval($store[$i]['distance']);
                    }   
                }
            }
            return array($yearmil,$monthmil,$weekmil);
        }
        
        public static function divideIntoMonths($thisyear) { //this year is an array containing all of the runs logged this year
            
            
        }
    }
    ?>
