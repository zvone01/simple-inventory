<?php
class Ale{
 
    // database connection and table name
    private $conn;
    private $table_name = "article_ledger_entry";
 
    // object properties
    public $id;
    public $article_id;
    public $quantity;
    public $document_no;
    public $user_id;
    public $timestamp;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
        $this->user_id =1;
    }


    // read articles
    function read_all(){
    
        // select all query
        $query = "SELECT *  FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create article
function create(){
 
    // query to insert record
    $query = "INSERT INTO `article_ledger_entry` (`id`, `article_id`, `quantity`, `document_no`, `user_id`, `timestamp`) VALUES (NULL, :article_id, :quantity, :document_no, :user_id, CURRENT_TIMESTAMP);
              UPDATE `article` SET `stock` = `stock`+ :quantity WHERE `article`.`id` = :article_id;";
    // prepare query
    $stmt = $this->conn->prepare($query);
 

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->article_id));
        $this->name=htmlspecialchars(strip_tags($this->quantity));
        $this->price=htmlspecialchars(strip_tags($this->document_no));
        $this->description=htmlspecialchars(strip_tags($this->user_id));
     
        // bind values
        $stmt->bindParam(":article_id", $this->article_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":document_no", $this->document_no);
        $stmt->bindParam(":user_id", $this->user_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}



function get_by_article_id()
{
   // delete query
   $query = "SELECT * FROM " . $this->table_name . " WHERE article_id =:article_id";
 
   // prepare query
   $stmt = $this->conn->prepare($query);

   // sanitize
   $this->article_id=htmlspecialchars(strip_tags($this->article_id));
  

   
   $stmt->bindParam(":article_id", $this->article_id);
   

  $stmt->execute();
  return $stmt;

}

function get_by_id(){
 
    $this->id=htmlspecialchars(strip_tags($this->id));

    // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . " WHERE id = ".$this->id;

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    
    // execute query
    $stmt->execute();
    
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($stmt->rowCount() < 1)
        return false;
    // set values to object properties
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->description = $row['description'];
    $this->stock = $row['stock'];
    return true;
}

}