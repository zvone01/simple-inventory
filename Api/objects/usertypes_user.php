<?php
class UserTypesUser
{

    private $conn;
    public $UserID;
    public $TypeID;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    function read()
    {
    
        $query = "SELECT 
                    *  
                  FROM 
                    usertypes_user";   
     
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
    
        return $stmt;
    }

    function create()
    {
 
        $query = "INSERT INTO
                    usertypes_user 
                  SET 
                    UserID=:UserID, 
                    TypeID=:TypeID";
     

        $stmt = $this->conn->prepare($query);

        $this->UserID=htmlspecialchars(strip_tags($this->UserID));
        $this->TypeID=htmlspecialchars(strip_tags($this->TypeID));

        $stmt->bindParam(":UserID", $this->UserID);
        $stmt->bindParam(":TypeID", $this->TypeID);

        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
    


}