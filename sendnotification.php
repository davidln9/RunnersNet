<?php
class SendNotification {
    
    //non-static function this time
    public function notify($ptype, $ntype, $pID, $userID, $db, $cid, $group) {
        
        //make sure the notification is from a different user
        if ($userID != $cid) {
            
            date_default_timezone_set('MST');
            $date = date("m/d/Y g:i a");
        
            // echo "ptype: ".$ptype." ntype: ".$ntype." pID: ".$pID." cid: ".$cid." uID: ".$userID." date: ".$date." sts: ".$status." ".$group."<br>";
            if ($call = mysqli_query($db, "CALL SENDNOTIFICATION($ptype, $ntype, $pID, $cid, $userID, '$date', $group)")) {
            
                return true;
            } else {
                
                echo "dd: ".mysqli_error($db);
            }
        } else {
            return true;
        }
    }
    public function unNotify($ptype, $ntype, $pID, $userID, $db, $cid, $group) {
        
        if ($call = mysqli_query($db, "CALL REMOVENOTIFICATION($ptype, $ntype, $pID, $cid, $userID, $group)")) {
            return true;
        } else {
            return mysqli_error($db);
        }
    }
}


?>
