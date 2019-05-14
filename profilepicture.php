<?php
    class profilepic {
        
        public static function getProfilePic($ht) {
            
            include 'sessioncheck.php';
            
            $image = $_SESSION['profilepic'];
            if ($image != NULL) {

				$name = "";
				for ($i = 0; $i < strlen($image); $i++) {
					if ($image[$i] == '/') {
						$name = "";
					} else {
						$name = $name.$image[$i];
					}
				}
                return "<img src='uploads/$name' height='$ht'>";
            } else {
                $image = "/uploads/default.png";
                $imageData = base64_encode(file_get_contents($image));
                $src='data: '.mime_content_type($image).';base64,'.$imageData;
                $retval = $src;
                return $retval;
            }
        }
        
        public static function getPic($w, $pic) {
            include 'sessioncheck.php';
            
			$image = $pic;
		$name = "";
                for ($i = 0; $i < strlen($image); $i++) {
                    if ($image[$i] == '/') {
                        $name = "";
                    } else {
                        $name = $name.$image[$i];
                    }
                }	
			return "<img src='uploads/$name' width='$w'>";
        }
    }
    ?>

