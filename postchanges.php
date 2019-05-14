<?php
    include 'sessioncheck.php';
    include 'pacecalc.php';
    if (isset($_POST['btnsavetext'])) {
        $text = mysqli_real_escape_string($db, $_POST['txttext']);
        $pid = intval($_POST['postID']);
        $ptype = intval($_POST['posttype']);
        $call = mysqli_query($db, "CALL EditPostText('$cid','$ptype','$pid','$text')");
        if (!$call) {
            echo mysqli_error($db);
        } else {
            $query = array('id' => $cid, 'type' => $ptype, 'postid' => $pid);
            $query = http_build_query($query);
            header("location: editpost.php?$query");
        }
    }
    if (isset($_POST['btnsavepic'])) {

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
           && $imageFileType != "gif" && $imageFileType != "mp3" && $imageFiletype != "MP3" && $imageFileType != "mp4" && $imageFileType != "MP4" && $imageFileType != "MOV" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
            header("location: editpost.php?error=5");
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
                $pid = intval($_POST['postID']);
                $ptype = intval($_POST['posttype']);
                if ($call=mysqli_query($db,"CALL EditPostPic('$cid','$ptype','$pid','$target_file')")) {
                    $query = array('id' => $cid, 'type' => $ptype, 'postid' => $pid);
                    $query = http_build_query($query);
                    header("location: editpost.php?$query");
                } else {
                    echo mysqli_error($db);
                }
                
                
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            
            
        }
    }
    if (isset($_POST['btnUpdateDistance'])) {
        
        date_default_timezone_set("MST");
        $public = intval($_POST['public']);
        $pid = $_POST['pid'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $team = $_POST['team'];
        $distance = $_POST['distance'];
        $runtime = $_POST['runtime'];
        $journal = $_POST['journal'];
        $intensity = $_POST['intensity'];
        
        echo "pid: ".$pid." date: ".$date." time: ".$time." location: ".$location." team: ".$team." distance: ".$distance." runtime: ".$runtime." journal: ".$journal." Intensity: ".$intensity." public: ".$public;
        
        if ($date == "" || $time == "" || $location == "" || $team == "" || $distance == "") {
            header("location: editpost.php?type=0&postid=$pid&msg=1");
        } else {
            
            $journal = mysqli_real_escape_string($db, $journal);
            $location = mysqli_real_escape_string($db, $location);
            $pace = "";
            $datetime = $date." ".$time;
            if ($runtime != "" && $runtime != "N/A" && $runtime != "n/a" && $runtime != "na" && $runtime != "NA") {
                
                $calculator = new PaceCalculator;
                $pace = $calculator->calculatePace($distance, $runtime);
            } else {
                $pace = "N/A";
            }
            
            if ($call = mysqli_query($db, "CALL UPDATEDISTANCE($pid, $public, '$datetime', '$location', '$team', '$intensity', '$journal', '$runtime', '$pace', $distance)")) {
                header("location: editpost.php?type=0&postid=$pid&msg=3");
            } else {
                header("location: editpost.php?type=0&postid=$pid&msg=2");
                // echo mysqli_error($db);
            }
        }
    }
    if (isset($_POST['btnUpdateSpeed'])) {
        $location = $_POST['location'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $description = $_POST['description'];
        $team = $_POST['team'];
        $journal = $_POST['journal'];
        $public = $_POST['public'];
        $warmup = floatval($_POST['warmup']);
        $workout = floatval($_POST['workout']);
        $cooldown = floatval($_POST['cooldown']);
        $pid = $_POST['postid'];
        
        // echo "Location: ".$location." date: ".$date." Time: ".$time." desc: ".$description." team: ".$team." journal: ".$journal." warmup: ".$warmup." workout: ".$workout." cooldown: ".$cooldown." pid: ".$pid." public: ".$public;
        
        if ($location == "" || $date == "" || $time == "" || $description == "" || $team == "" || $journal == "" || $warmup == "" || $workout == "" || $cooldown == "") {
            header("location: editpost.php?type=1&postid=$pid&msg=1");
        } else {

            $datetime = $date." ".$time;
            $journal = mysqli_real_escape_string($db, $journal);
            $location = mysqli_real_escape_string($db, $location);
            $description = mysqli_real_escape_string($db, $description);
            $team = mysqli_real_escape_string($db, $team);

            $distance = $warmup + $workout + $cooldown;

            if ($call = mysqli_query($db, "CALL UPDATESPEED($pid, '$location', '$datetime', '$description', $distance, '$team', '$journal', $public, $warmup, $cooldown, $workout)")) {
                header("location: editpost.php?type=1&postid=$pid&msg=3");
            } else {
                echo mysqli_error($db);
                //header("location: editpost.php?type=1&postid=$pid&msg=2");
            }
        }
    }
    ?>
