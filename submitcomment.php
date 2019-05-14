<?php
    include "sessioncheck.php";
    require 'sendnotification.php';
    if(isset($_POST)) {
        $pageowner = $_POST['pageowner'];
	$posttype = intval($_POST['ptype']);
        $type = 5;
        $pid = intval($_POST['postID']);
        date_default_timezone_set('MST');
        $date = date("m/d/Y g:i a");
        $txt = $_POST['text'];
        $page = (int)$_POST['page'];
        $posterID = $_POST['posterID'];
        $txt = mysqli_real_escape_string($db, $txt);
		$txt = strip_tags($txt, "<br>");
		//echo "Text: ".$txt."<br>";
		$commenter = $cid;
        
        if ($page == 5) {
            $commenter = $_POST['commenter'];
            $type = 10;
        } elseif ($page == 4) {
            $pageID = $_POST['pageID'];
            
        }
        
        $commid;
        if ($call = mysqli_query($db, "CALL GetCommentID")) {
            $row = mysqli_fetch_array($call, MYSQLI_NUM);
            $commid = intval($row[0] + 1);
            $call->free();
            $db->next_result();
//            echo "comid=".$commid;
//            echo "Post type: ".$posttype;
//            echo "Post ID: ".$pid;
		}
		//echo "CALL InsertComment('$type','$posttype','$pid','$commid','$date',$commenter,'$txt',NULL)"."<br>";
        if ($call = mysqli_query($db, "CALL InsertComment('$type','$posttype','$pid','$commid','$date',$commenter,'$txt',NULL)")) {
            
            //send notification to poster
            $action = new SendNotification();
            $notify = $action->notify($posttype, 1, $pid, $posterID, $db, $commenter, 0);
            
            unset($action);
            // echo $page." ".$posterID;
//             exit;
            
            if ($notify != 1) {
                exit;
            } else {
                switch ($page) {
                    case 0:
                    header('location: home.php');
                    break;
                    case 1:
                    header('location: profilepage.php');
                    break;
                    case 3:
                    header("location: viewprofile.php?id=$pageowner");
                    break;
                    case 4:
                    header("location: viewgroup.php?id=$pageID");
                    break;
                    case 5:
                    header("location: admintools.php?id=$commenter");
                    break;
                    default:
                    header('location: home.php');
                    break;
                }
            }
            
            //header('location: profilepage.php');
        } else {
            echo "here ".mysqli_error($db);
        }
        
    }
    ?>
