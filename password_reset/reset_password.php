<?php

include 'connect.php';

$conn = new mysqli($servername , $username ,$password , $dbname);
 
if($conn->connect_error){
        die("Connection failed :" . $conn->connect_error);
 }

$response = array("error" => FALSE);

    $password = $_POST['password'];
    $email = $_POST['email'];
    
    $salt = sha1(rand());
    $salt = substr($salt, 0, 10);
    
    $encrypted = base64_encode(sha1($password.$salt, true).$salt);
    $hash = array("salt" => $salt , "encrypted" => $encrypted);
    
    $encrypted_password = $hash["encrypted"]; 
    $salt = $hash["salt"]; 
    
    $sql = "UPDATE users SET encrypted_password = '".$encrypted_password."' , salt = '".$salt."' WHERE email= '".$email."'";
    
    $result = $conn->query($sql);
    
    if($result){
     	$response['error'] = FALSE;
   	echo json_encode($response);
    }else{
   	$response['error'] = TRUE;
   	echo json_encode($response);
    }
    