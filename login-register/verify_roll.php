<?php
session_start();

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

//json response array
$response = array("error" => FALSE);

/*Check if required parameter is set, else return error*/
if (isset($_POST['roll'])) {

    // receiving the post params
    $roll = $_POST['roll'];
    
   
    /* check if roll exists in DB_TABLE: roll
       if YES check if roll is registered or not OR if NO return error */

    if ($db->ifRollExists_Defined($roll)) {   
    
        	/* check if roll is already registered in DB_TABLE: user 
		   if YES return error, if NOT proceed to register*/
    
                if($db->ifRollExists_User($roll)){        
                  $response["error"] = TRUE; 
                  $response["error_msg"] = "User with same roll already exists !";  
                  echo json_encode($response);    
                }
                else{        
                  $response["error"] = FALSE;
                  echo json_encode($response);
                    }          
     } 
     else {     
         $response["error"] = TRUE;
         $response["error_msg"] = "Please Enter the correct roll number !";
         echo json_encode($response);
         }
         
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter is missing!";
    echo json_encode($response);
}

?>
