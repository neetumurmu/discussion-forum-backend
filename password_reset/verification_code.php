<?php

require 'PHPMailer/PHPMailerAutoload.php';
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array("error" => FALSE);

$email = $_POST['email'];

if ($db->isUserExisted($email)) {

        $random = rand(10000 , 99999);
        $random = (string)$random;
      
        $response["error"] = FALSE;
        $response["code_server"] = $random;
        
       // print_r($response);
        
        $mail = new PHPMailer;

	$mail->SMTPDebug = 0;                                 // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'localhost';  			      // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'your_email@mail.com';               // SMTP username
	$mail->Password = 'your_password';                         // SMTP password
	$mail->SMTPSecure = 'tls'; 
	$mail->SMTPAutoTLS = false;    
	$mail->SMTPOptions = array(
    				'ssl' => array(
   			        'verify_peer' => false,
  			        'verify_peer_name' => false,
       				 'allow_self_signed' => true
   				 )
				);                      
	$mail->Port = 587;                                    // TCP port to connect to
	$mail->setFrom('your_email@mail.com', 'username');
 	$mail->addAddress($email);               // Name is optional
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'Password Reset';		
	$mail->Body    = 'Verification Code for password change :  '.$response["code_server"];

	if(!$mail->send()) {
   		 echo 'Message could not be sent.';
   		 echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
  		  echo json_encode($response);
	}
        
        
        
    }else{
        
        $response["error"] = TRUE;
        $response["error_msg"] = "This email address is not registered with any account!";
        echo json_encode($response);
    }
    
    

?>
