<?php
 
class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

  /*  Allowed Roll Number Database  -  ROll Check    */
    public function ifRollExists_Defined($roll){
    
        $stmt = $this->conn->prepare("SELECT roll FROM roll_table WHERE roll = ?");       
        $stmt->bind_param("s" , $roll);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows > 0){
                $stmt->close();
                return true;
        }
        else{
                $stmt->close();
                return false;
        }          
    }


        /*  Registered User Database - Roll check  */
        
        public function ifRollExists_User($roll){
    
        $stmt = $this->conn->prepare("SELECT roll FROM users WHERE roll = ?");       
        $stmt->bind_param("s" , $roll);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows > 0){
                $stmt->close();
                return true;
        }
        else{
                $stmt->close();
                return false;
        }      
        
        }    
    

    /* Check user is exists with the same email or not */
    
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
    
    
    /*Format Date*/
    
    public function dateFormat($mysqldate){
        $date = date_create($mysqldate); 
        $new = date_format($date,"d M 'y  \\a\\t  h:i A");
         
        return $new;
    }
 
 
        /*Ask new question*/
    
     public function write_question($topic , $description ,$name){
        $stmt = $this->conn->prepare("INSERT into questions(topic,description,created_by,created_at) values(?,?,?,NOW() + INTERVAL 330 MINUTE)");      
        $stmt->bind_param("sss", $topic , $description, $name);
        $result = $stmt->execute();
        $stmt->close();
        
       return $result; 
    
    }
        /*Post an answer*/
        
     public function write_answer($que_id , $answer ,$name){
    
        $stmt = $this->conn->prepare("INSERT into replies(que_id, reply , created_by ,created_at) values(? , ? , ? , NOW() + INTERVAL 330 MINUTE)");      
        $stmt->bind_param("sss", $que_id , $answer , $name);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    
    }

 /*Fetch Answer for a question*/
    
    public function fetch_answer($que_id){            
        $stmt = $this->conn->prepare("SELECT * FROM replies WHERE que_id = ?");
        $stmt->bind_param("s" , $que_id);
        $stmt->execute();      
        $response = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        return $response;
        
    }
    
    
       
    
}

?>
