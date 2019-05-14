<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'secure.php';
if (isset($_POST['btnSubmit'])) {
    require '/var/PHPMailer/PHPMailerAutoload.php';
	$email = $_POST['recoveremail'];
        
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $db = mysqli_connect($server,$user,$password,$database) or die("no connection");
        if (!($call = mysqli_query($db, "CALL LOGIN('$email')"))) {
            echo mysqli_error($db);
            exit;
        }
        if (mysqli_num_rows($call) == 1) {
            $call->free();
            $db->next_result();

            date_default_timezone_set("MST");
            $date = date("m/d/Y g:i a");
            $expires = strtotime($date) + 60*60;
            $expdate = date("m/d/Y g:i a", $expires);

            $code = mt_rand(0,999999999);
            
            $link = "http://www.therunnersnet.com/resetpassword.php?user=".$email."&id=".$code;

            if ($call = mysqli_query($db, "CALL SETUPRECOVERY('$email', $code, '$expdate')")) {
                $mail = new PHPMailer(true);
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output
				try {
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'donotreply@therunnersnet.com';                 // SMTP username
					$mail->Password = 'HermJayden19';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to
					//$mail->SMTPDebug = 3;
					$mail->setFrom('donotreply@therunnersnet.com', 'The RunnersNet');
					$mail->addAddress($email);     // Add a recipient

					$mail->isHTML(true);                                  // Set email format to HTML

					$mail->Subject = 'Password Reset Link';
					$mail->Body    = 'Click the Link or copy and paste into your browser<br>'.$link;
					$mail->AltBody = 'Click the link or copy and paste into your browser.  '.$link;
					$mail->send();
					header("location: recovery.php?error=90");
				} catch (Exception $e) {
					echo 'message could not be sent: '. $mail->ErrorInfo;
				}
			} else {
				echo mysqli_error($db);
			}

        } else {
            header("location: recovery.php?error=4");
        }
    } else {
        header("recovery.php?error=1");
    }
    
}
    if (isset($_POST['btnSubmitPass'])) {
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $email = $_POST['email'];
        $id = $_POST['id'];
        // echo $pass1."<br>";
//         echo $pass2."<br>";
//         echo $email."<br>";
//         echo $id;
        
        if ($pass1 != $pass2) {
            header("location: resetpassword.php?error=1&user=$email&id=$id");
            // echo "error1";
        } elseif ($pass1 == "") {
            // echo "error2";
            header("location: resetpassword.php?error=2&user=$email&id=$id");
        } else {
            // echo "hi";
            $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
            // echo $pass1;
			$db = mysqli_connect($server,$user,$password,$database) or die("no connection");
			if ($call = mysqli_query($db, "CALL RESETPASSWORD('$email', '$pass1')")) {
                
                // echo "success!";
            } else {
                echo "here ".mysqli_error($db);
            }
            if (!$call = mysqli_query($db, "CALL DELETEPASSWORDRECOVERY('$email')")) {
                echo "error";
            } else {
                 header("location: index.php?id=99");
            }
        }
    }
?>
