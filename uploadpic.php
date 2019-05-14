<?php
    include 'sessioncheck.php';
    class uploadpic {
        public static function UploadPicture($target_dir,$target_file,$imageFileType,$pic,$fname) {
           //$_FILES["fileToUpload"]["tmp_name"] = $pic;
//    $target_dir = "uploads/";
//    $target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
    $uploadOk = 1;
//    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
   // $edit=false;
//    if(isset($_POST["submitPhoto"])) {
//        $edit = false;
//        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//        if($check !== false) {
//            $uploadOk = 1;
//        } else {
//            echo "File is not an image.";
//            $uploadOk = 0;
//        }
//    } elseif (isset($_POST["btnSubmitPhoto"])) {
//        $edit = true;
//        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//        if($check !== false) {
//            $uploadOk = 1;
//        } else {
//            echo "File is not an image.";
//            $uploadOk = 0;
//        }
//    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($pic > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    $fext = minimime($fname);
    // Allow certain file formats
    if(!$fext) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed."
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return array(0, NULL);
        // if everything is ok, try to upload file
    } else {
        //$_FILES["fileToUpload"]["tmp_name"] = $pic;
        if (move_uploaded_file($pic, $target_file)) {
//            $former = $_SESSION['profilepic'];
//            $uname = $_SESSION['username'];
            $picture = realpath($target_file);
//            $pic = $_SESSION['profilepic'];
            if ($call=mysqli_query($db,"CALL InsertPost('$uname','$id','$text','$date','$picture')")) {
                $call->free();
                //header('location: home.php');
            } else {
                echo mysqli_error($db);
            }
            
            
        } else {
            return array(0,NULL);
        }
    }
    }
        function minimime($fname) {
            $fh=fopen($fname,'rb');
            if ($fh) {
                $bytes6=fread($fh,6);
                fclose($fh);
                if ($bytes6===false) {
                    return false;
                }
                
                if (substr($bytes6,0,3)=="\xff\xd8\xff") {
                    return true;
                }
                
                if ($bytes6=="\x89PNG\x0d\x0a") {
                    return true;
                }
                
                if ($bytes6=="GIF87a" || $bytes6=="GIF89a") {
                    return true;
                }
                
                
            }
            return false;
        }
    }
    ?>
