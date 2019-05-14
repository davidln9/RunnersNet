<?php
    include 'sessioncheck.php';
    require 'sendnotification.php';
    //include 'uploadpic.php';
    //echo "hello";
    if (isset($_POST['btnSubmitText'])) {
        $page = $_POST['page'];
        $call = mysqli_query($db,"CALL GetPagePostID");
        $postee = (isset($_POST['postee'])) ? $_POST['postee'] : null ;
        $id;
        if (!$call) {
            echo "Major Error";
        } else {
            $row = mysqli_fetch_assoc($call);
            $id = (intval($row["id"]) + 1);
            $call->free();
            $db->next_result();
        }
        $text = mysqli_real_escape_string($db,$_POST['content']);
        $type = $_POST['type'];
        date_default_timezone_set('MST');
        $date = date("m/d/Y g:i a");
        
        if ($_FILES["fileToUpload"]["name"] == NULL) {
            $call = mysqli_query($db, "CALL InsertPagePost('$type','$cid','$postee','$date','$id','$text',NULL)");
            if (!$call) {
                echo "1 ".mysqli_error($db);
            } else {
                $action = new SendNotification();
                $notify = $action->notify($type, 6, $id, $postee, $db, $cid, 0);
                if (!($notify)) {
                    echo "notify error";
                    exit;
                }
                if ($page == 2) {
                    
                    header('location: viewgroup.php?id='.$postee);
                } else {
                    header('location: viewprofile.php?id='.$postee);
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
            if ($_FILES["fileToUpload"]["size"] > 100000000) {
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
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    //                    $former = $_SESSION['profilepic'];
                    //                    $uname = $_SESSION['username'];
                    //                    $_SESSION['profilepic'] = realpath($target_file);
                    //                    $pic = $_SESSION['profilepic'];
                    $picture = realpath($target_file);
                    if ($call=mysqli_query($db,"CALL InsertPagePost('$type','$cid','$postee','$date','$id','$text','$target_file')")) {
                        if ($page == 2)
                            header("location: viewgroup.php?id=$postee");
                        else
                            header('location: viewprofile.php?id='.$postee);
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
