<?php
class User
{

    private $conn;
 
    public $ID;
    public $Name;
    public $Surname;
    public $Username;
    public $Password;
    public $Email;
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
                    user 
                INNER JOIN 
                    usertypes_user
                ON 
                    user.ID=usertypes_user.UserID";

        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
    
        return $stmt;
    }

function create()
{

    $query = "INSERT INTO
                user 
            SET 
                Name=:Name, 
                Surname=:Surname,  
                Username=:Username, 
                Password=:Password, 
                Email=:Email";

    $stmt = $this->conn->prepare($query);

    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Surname=htmlspecialchars(strip_tags($this->Surname));
    $this->Username=htmlspecialchars(strip_tags($this->Username));
    $this->Password=htmlspecialchars(strip_tags($this->Password));
    $this->Email=htmlspecialchars(strip_tags($this->Email));

    $stmt->bindParam(":Name", $this->Name);
    $stmt->bindParam(":Surname", $this->Surname);
    $stmt->bindParam(":Username", $this->Username);
    $stmt->bindParam(":Password", $this->Password);
    $stmt->bindParam(":Email", $this->Email);

    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function delete()
{
    $query = "DELETE FROM user WHERE ID = ?";
 
    $stmt = $this->conn->prepare($query);
 
    $this->ID=htmlspecialchars(strip_tags($this->ID));
 
    $stmt->bindParam(1, $this->ID);

    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function get_user()
{
   $query = "SELECT * FROM user WHERE Username =:Username AND Password=:Password";
 
   $stmt = $this->conn->prepare($query);

   $this->Username=htmlspecialchars(strip_tags($this->Username));
   $this->Password=htmlspecialchars(strip_tags($this->Password));

   $stmt->bindParam(":Username", $this->Username);
    $stmt->bindParam(":Password", $this->Password);

  $stmt->execute();
    
  
       return $stmt;

}

function get_user_name()
{
   // delete query
   $query = "SELECT * FROM user WHERE Username =:Username";
   // prepare query
   $stmt = $this->conn->prepare($query);
   // sanitize
   $this->Username=htmlspecialchars(strip_tags($this->Username));
   // bind id of record to delete
   $stmt->bindParam(":Username", $this->Username);
   
   $stmt->execute();
   return $stmt;
}

function get_lastuser_id()
{
   // delete query
   $query = "SELECT ID FROM user WHERE Username =:Username";
   // prepare query
   $stmt = $this->conn->prepare($query);
   // sanitize
   $this->Username=htmlspecialchars(strip_tags($this->Username));
   // bind id of record to delete
   $stmt->bindParam(":Username", $this->Username);
   
   $stmt->execute();
   return $stmt;
}

function get_user_by_email(){
    // delete query
    $query = "SELECT * FROM user WHERE Email =:Email";
    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    // bind id of record to delete
    $stmt->bindParam(":Email", $this->Email);

    $stmt->execute();
    return $stmt;
}

function updatePass(){
 
    // update query
    $query = "UPDATE
                user
            SET
                Password = :Password            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Password=htmlspecialchars(strip_tags($this->Password));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Password', $this->Password);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}

function updateEmail(){
 
    // update query
    $query = "UPDATE
                user
            SET
                Email = :Email            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}


function updateToken(){
 
    // update query
    $query = "UPDATE
                user
            SET
            ResetToken = :ResetToken            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->ResetToken=htmlspecialchars(strip_tags($this->ResetToken));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':ResetToken', $this->ResetToken);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}
}