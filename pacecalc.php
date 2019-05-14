<?php

class PaceCalculator {
    
    public function calculatePace($length, $runtime) {
        
        if ($runtime !== "" && $runtime !== "N/A" && $runtime !== "n/a" && $length !== "") {
            $rseconds = intval(substr($runtime, 6));
            $rminutes = intval(substr($runtime, 3, 2));
            $rhours = intval(substr($runtime, 0, 2));
            
            $totalSeconds = $rseconds + $rminutes*60 + $rhours*60*60;
            $avgSeconds = intval($totalSeconds/$length);
            $avgMinutes = 0;
            $avgHours = 0;
            
            if ($avgSeconds < 10) {
                $avgPace="00:00:0".'$avgSeconds';
            } elseif ($avgSeconds < 60) {
                $avgPace = "00:00:".'$avgSeconds';
            } elseif ($avgSeconds == 60) {
                $avgPace = "00:01:00";
            } else {
                while ($avgSeconds >= 60) {
                    $avgSeconds -= 60;
                    $avgMinutes++;
                }
                while ($avgMinutes >= 60) {
                    $avgMinutes-=60;
                    $avgHours++;
                }
            }
            
            $secondstring;
            if ($avgSeconds < 10) {
                $secondstring = "0".strval($avgSeconds);
            } else {
                $secondstring = strval($avgSeconds);
            }
            $minutestring;
            if ($avgMinutes < 10 && $avgHours == 0) {
                $minutestring = strval($avgMinutes);
            } elseif ($avgMinutes <10 && $avgHours >0) {
                $minutestring="0".strval($avgMinutes);
            } elseif ($avgMinutes >= 10) {
                $minutestring=strval($avgMinutes);
            }
            $hourstring;
            if ($avgHours < 10 && $avgHours > 0) {
                $hourstring = "0".strval($avgHours);
                $nocolon = false;
            } elseif ($avgHours >= 10) {
                $hourstring = strval($avgHours);
                $nocolon = false;
            } elseif ($avgHours == 0) {
                $hourString = "";
            }
            if ($hourString == "") {
                $avgPace = $minutestring.":".$secondstring;
            } else {
                $avgPace = $hourstring.":".$minutestring.":".$secondstring;
            }
            
            return $avgPace;
        } else {
            
            $avgPace = "N/A";
            return $avgPace;
        }
    }
}
    ?>
