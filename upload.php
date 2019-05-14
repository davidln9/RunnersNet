<?php
include 'sessioncheck.php';
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["ImageUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


$edit;
if (isset($_POST["submitPhoto"])) {
    $edit = 0;
} elseif (isset($_POST["btnSubmitPhoto"])) {
    $edit = 1;
    
} elseif (isset($_POST['groupProfilePic'])) {
    $edit = 2;
} elseif (isset($_POST['btnEditGroupPic'])) {
    $edit = 3;
    $group = $_POST['groupID'];
}


if ($_FILES["ImageUpload"]["size"] == 0) {

   switch ($edit) {
       case 0:
       header("location: accountsetup6.php?error=1");
       break;
       case 1:
       header("location: editprofile.php?id=1&error=1");
       break;
       case 2:
       header("location: groupsetup7.php?error=1");
       break;
       case 3:
       header("location: editprofile.php?id=2&group=$group&error=1");
       break;
       default:
       header("location: home.php");
       break;
   }
}
$check = getimagesize($_FILES["ImageUpload"]["tmp_name"]);
if($check !== false) {
    $uploadOk = 1;
} else {
    $uploadOk = 0;
    switch ($edit) {
        case 0:
        header("location: accountsetup6.php?error=0");
        break;
        case 1:
        header("location: editprofile.php?id=1&error=0");
        break;
        case 2:
        header("location: groupsetup7.php?error=0");
        break;
        case 3:
        header("location: editprofile.php?id=2&group=$group&error=0");
        break;
        default:
        header("location: home.php");
        break;
    }
    //$uploadOk = 0;
}

$temp = explode(".", $_FILES["ImageUpload"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
$target_file = $target_dir . $newfilename;

// Check if file already exists
while (file_exists($target_file)) {
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $target_file = $target_dir . $newfilename;
}
// Check file size
if ($_FILES["ImageUpload"]["size"] > 10000000) {
    $uploadOk = 0;
    switch ($edit) {
        case 0:
        header("location: accountsetup6.php?error=7");
        break;
        case 1:
        header("location: editprofile.php?id=1&error=7");
        break;
        case 2:
        header("location: groupsetup7.php?error=7");
        break;
        case 3:
        header("location: editprofile.php?id=2&group=$group&error=7");
        break;
        default:
        header("location: home.php");
        break;
    }
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF") {
    
    $uploadOk = 0;
    switch ($edit) {
        case 0:
        header("location: accountsetup6.php?error=4");
        break;
        case 1:
        header("location: editprofile.php?id=1&error=4");
        break;
        case 2:
        header("location: groupsetup7.php?error=4");
        break;
        case 3:
        header("location: editprofile.php?id=2&group=$group&error=4");
        break;
        default:
        header("location: home.php");
        break;
    }
} 
// echo "shouldn't be here";
// exit;
//Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {

    if ($edit != 2) {
        if (move_uploaded_file($_FILES["ImageUpload"]["tmp_name"], $target_file)) {
            $former = $_SESSION['profilepic'];
            $uname = $_SESSION['username'];

            $pic = realpath($target_file);
            if ($edit == 0) {
                $_SESSION['profilepic'] = realpath($target_file);
                header('location: accountsetup5.php');
            } elseif ($edit == 1) {
                $_SESSION['profilepic'] = realpath($target_file);
                $call=mysqli_query($db, "CALL setOldProfPic('$cid','$former')");

                if (!$call) {
                    echo "<p>Error</p>";
                }

                $call=mysqli_query($db, "CALL updateProfilePic('$cid','$pic')");
                if (!$call) {
                    header('location: editprofile.php?id=1&error=7');
                } else {
                    header('location: editprofile.php?id=1');
                }
            } elseif ($edit == 3) {

                $group = $_POST['groupID'];
                if (!($call = mysqli_query($db, "CALL UPDATEGROUPPROFILEPIC('$pic', $group)"))) {
                    echo "groupprofilepic: ".mysqli_error($db);
                } else {
                    header("location: editprofile.php?id=2&group=$group");
                }
            }
        } else {
            echo "1. Sorry, there was an error uploading your file.";
        }
    } else {
        if (move_uploaded_file($_FILES["ImageUpload"]["tmp_name"], $target_file)) {

            $cryptID = mt_rand(0,200000000);
            $cryptcheck = array();
            $index = 0;
			include 'secure.php';
			$db = mysqli_connect($server,$user,$password,$database) or die("no connection");
			$password = $_SESSION['password'];
            $_SESSION['password'] = "";
            $bio = mysqli_real_escape_string($db, $_POST['txtBio']);


            //echo $cryptID;
            if ($call = mysqli_query($db, "CALL CheckCryptID")) {
                //echo "called";
                while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                    //echo "<br>yes";
                    $cryptcheck[$index] = intval($row[0]);
                    $index++;
                }
                $call->free();
                $db->next_result();
            } else {
                echo mysqli_error($db);
            }

            if ($call = mysqli_query($db, "CALL CHECKGROUPID")) {
                //echo "called";
                while ($row = mysqli_fetch_array($call, MYSQLI_NUM)) {
                    //echo "<br>yes";
                    $cryptcheck[$index] = intval($row[0]);
                    $index++;
                }
                $call->free();
                $db->next_result();
            } else {
                echo mysqli_error($db);
            }
            for ($i = 0; $i < $index; $i++) {
                if ($cryptID == $cryptcheck[$i]) {
                    $cryptID = mt_rand(0,300000000);
                    $i = -1;
                }
            }
            $img = realpath($target_file);
            $name = $_SESSION['groupname'];
            $type = $_SESSION['grouptype'];
            $policy = $_SESSION['method'];
            $location = $_SESSION['location'];
            $description = $_SESSION['bio'];
            $pgpolicy = $_SESSION['mod'];

            $description = mysqli_real_escape_string($db, $description);
            // echo "Crypt: ".$cryptID." name ".$name." type ".$type." policy ".$policy." cid ".$cid." loc ".$location." pg ".$pgpolicy;

            if (!($call = mysqli_query($db, "CALL CREATEGROUP($cryptID, '$name', $type, $policy, $cid, '$location', $pgpolicy, '$img', '$description')"))) {
                echo "Register: ".mysqli_error($db);
                exit;

            }
            if (!($call = mysqli_query($db, "CALL ADDGROUPMEMBER($cid, $cryptID, 3)"))) {
                echo "Register2: ".mysqli_error($db);
                exit;
            } else {
                header("location: home.php");
            }

        } else {
            echo "2. Sorry, there was an error uploading your file.";
        }
    }
}

?>
