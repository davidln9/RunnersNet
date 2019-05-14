<?php
    include 'sessioncheck.php';
    //include 'uploadpic.php';
    //echo "hello";
    if (isset($_POST['btnSubmitText'])) {
        $call = mysqli_query($db,"CALL GetPostID");
        $id;
        if (!$call) {
            echo "Major Error";
        } else {
            $row = mysqli_fetch_assoc($call);
            $id = (intval($row["id"]) + 1);
            $call->free();
            $db->next_result();
        }
        $text = mysqli_real_escape_string($db, $_POST['content']);
        $type = $_POST['type'];
        $encid = $_POST['encid'];
        date_default_timezone_set('MST');
        $date = date("m/d/Y g:i a");
        
        if ($_FILES["fileToUpload"]["name"] == NULL) {
			$text = strip_tags($text, '<br>');
			$call = mysqli_query($db, "CALL InsertPost($type, $encid, $id, '$date', '$text', NULL)");
            if (!$call) {
                echo mysqli_error($db);
            } else {
                if ($encid == $cid) {
                    $page = $_POST['page'];
                    switch ($page) {
                        case 0:
                        header("location: home.php");
                        break;
                        case 1:
                        header("location: profilepage.php");
                        break;
                        default:
                        header("location: home.php");
                        break;
                    }
                } else {
                    header("location: admintools.php?id=$encid");
                }
            }
        } else {
            
            $target_dir = "uploads/";
            $realdir = "/uploads/";
            $uploadOk = 1;
            
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $target_file = $target_dir . $newfilename;
            $realfile = $realdir . $newfilename;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 10000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
               && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            if ($imageFileType == "mp4" || $imageFileType == "MP4" || $imageFileType == "mov" || $imageFileType == "MOV") {
                $type = 6;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                //echo "reached";
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    //                    $former = $_SESSION['profilepic'];
                    //                    $uname = $_SESSION['username'];
                    //                    $_SESSION['profilepic'] = realpath($target_file);
                    //                    $pic = $_SESSION['profilepic'];
                    $picture = realpath($target_file);
					$text = strip_tags($text, '<br>');
					if ($call=mysqli_query($db,"CALL InsertPost($type, $encid, $id, '$date','$text','$target_file')")) {
                        if ($encid == $cid)
                            header('location: profilepage.php');
                        else
                            header("location: admintools.php?id=$encid");
                    } else {
                        echo mysqli_error($db);
                    }
                    
                    
                    
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
                
                
            }
        }
    }
    
    ?>
