<?php
    include 'sessioncheck.php';
    
    if (isset($_POST['btnSubmitText'])) {
        $receiver = intval($_POST['receiver']);
        $text = mysqli_real_escape_string($db, $_POST['content']);
        $text = strip_tags($text, '<br>');
        if ($call = mysqli_query($db, "CALL GetMessageId")) {
            $row = mysqli_fetch_array($call, MYSQLI_BOTH);
            $id = $row['id'] + 1;
            
            
            
            $call->free();
            $db->next_result();
            
        } else {
            echo "1".mysqli_error($db);
        }
        $legal = false;
        date_default_timezone_set('MST');
        $date = date("m/d/Y g:i a");
        if ($call = mysqli_query($db, "CALL GETFRIENDS($cid)")) {
            while ($row = mysqli_fetch_array($call, MYSQLI_BOTH)) {
                if ($row['person1'] == $receiver || $row['person2'] == $receiver) {
                    $legal = true;
                }

            }
            $call->free();
            $db->next_result();
        } else {
            echo "gf: ".mysqli_error($db);
        }
        echo $legal;
        if ($legal == true) {
            if ($call = mysqli_query($db, "CALL SendMessage('$cid', '$receiver', '$id', '$date', '$text', NULL)")) {
                header("location: sendmessage.php?id=$receiver");
            } else {
                echo "line 34 ".mysqli_error($db);
            }
        } else {
            echo "errors";
            exit;
        }
    }
    
    
    ?>
