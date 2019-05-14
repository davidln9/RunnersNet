<?php
// require "sessioncheck.php";
class FeedLoader {
    public function loadFeed($userID, $feed, $feedindex, $speedstmt, $diststmt, $racestmt, $poststmt, $pgpoststmt, $repoststmt, $db) {
        $diststmt->bind_param("i", $userID);
        $diststmt->execute();
        $result = $diststmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['public'] = $row['public'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['location'] = $row['location'];
            $feed[$feedindex]['team'] = $row['team'];
            $feed[$feedindex]['intensity'] = $row['intensity'];
            $feed[$feedindex]['journal'] = $row['journal'];
            $feed[$feedindex]['runtime'] = $row['runtime'];
            $feed[$feedindex]['pace'] = $row['pace'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['distance'] = $row['distance'];
            
            $feedindex++; 
        }
        $db->next_result();
            
            
        $racestmt->bind_param("i", $userID);
        $racestmt->execute();
        $result = $racestmt->get_result();
        //load races
        
        while ($row = $result->fetch_assoc()) {
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['distance'] = $row['distance'];
            $feed[$feedindex]['location'] = $row['location'];
            $feed[$feedindex]['racename'] = $row['racename'];
            $feed[$feedindex]['relay'] = $row['relay'];
            $feed[$feedindex]['runtime'] = $row['runtime'];
            $feed[$feedindex]['pace'] = $row['pace'];
            $feed[$feedindex]['journal'] = $row['journal'];
            
            $feedindex++; 
        }
        $db->next_result();
            
        
        $poststmt->bind_param("i", $userID);
        $poststmt->execute();
        $result = $poststmt->get_result();
        
        
        while ($row = $result->fetch_assoc()) {
            
            //load into feed array
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['text'] = $row['text'];
            $feed[$feedindex]['img'] = $row['img_filepath'];
            
            $feedindex++;
        }
        $db->next_result();
            
        $pgpoststmt->bind_param("i", $userID);
        $pgpoststmt->execute();
        $result = $pgpoststmt->get_result();
        
        //Load pageposts
        
        while ($row = $result->fetch_assoc()) {
            
            //LOAD into feed array
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['userID'] = $row['poster'];
            $feed[$feedindex]['postee'] = $row['postee'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['text'] = $row['text'];
            $feed[$feedindex]['img'] = $row['img_filepath'];
            
            $feedindex++;
        }
        $db->next_result();
            
        $repoststmt->bind_param("i", $userID);
        $repoststmt->execute();
        $result = $repoststmt->get_result();
        
        
        while ($row = $result->fetch_assoc()) {
            $feed[$feedindex]['type'] = $row['posttype'];
            $feed[$feedindex]['origType'] = $row['origPostType'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['origID'] = $row['origPostID'];
            $feed[$feedindex]['reposterID'] = $row['reposterID'];
            $feed[$feedindex]['date'] = $row['date'];
            $feedindex++;
        }
        $db->next_result();
        
        $speedstmt->bind_param("i", $userID);
        $speedstmt->execute();
        $result = $speedstmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['location'] = $row['location'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['description'] = $row['description'];
            $feed[$feedindex]['distance'] = $row['distance'];
            $feed[$feedindex]['team'] = $row['team'];
            $feed[$feedindex]['journal'] = $row['journal'];
            $feed[$feedindex]['public'] = $row['privacy'];
            
            $feedindex++;
        }
        $db->next_result();
        
        return array($feed, $feedindex);
    }
    
    public function loadRuns($feed, $diststmt, $racestmt, $speedstmt, $feedindex, $db, $userID) {
        $diststmt->bind_param("i", $userID);
        $diststmt->execute();
        $result = $diststmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['public'] = $row['public'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['location'] = $row['location'];
            $feed[$feedindex]['team'] = $row['team'];
            $feed[$feedindex]['intensity'] = $row['intensity'];
            $feed[$feedindex]['journal'] = $row['journal'];
            $feed[$feedindex]['runtime'] = $row['runtime'];
            $feed[$feedindex]['pace'] = $row['pace'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['distance'] = $row['distance'];
            
            $feedindex++; //increment
        }
        $db->next_result();
        
        $racestmt->bind_param("i", $userID);
        $racestmt->execute();
        $result = $racestmt->get_result();
        //load races
        
        while ($row = $result->fetch_assoc()) {
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['distance'] = $row['distance'];
            $feed[$feedindex]['location'] = $row['location'];
            $feed[$feedindex]['racename'] = $row['racename'];
            $feed[$feedindex]['relay'] = $row['relay'];
            $feed[$feedindex]['runtime'] = $row['runtime'];
            $feed[$feedindex]['pace'] = $row['pace'];
            $feed[$feedindex]['journal'] = $row['journal'];
            
            $feedindex++; //increment
        }
        $db->next_result();
        
        $speedstmt->bind_param("i", $userID);
        $speedstmt->execute();
        $result = $speedstmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $feed[$feedindex]['type'] = $row['type'];
            $feed[$feedindex]['id'] = $row['id'];
            $feed[$feedindex]['userID'] = $row['userID'];
            $feed[$feedindex]['location'] = $row['location'];
            $feed[$feedindex]['date'] = $row['date'];
            $feed[$feedindex]['description'] = $row['description'];
            $feed[$feedindex]['distance'] = $row['distance'];
            $feed[$feedindex]['team'] = $row['team'];
            $feed[$feedindex]['journal'] = $row['journal'];
            $feed[$feedindex]['public'] = $row['privacy'];
            
            $feedindex++;
        }
        $db->next_result();
        return array($feed, $feedindex);
    }
}
?>
