<?php
class ProductArticle{
 
    // database connection and table name
    private $conn;
    private $table_name = "product_article";
 
    // object properties
    public $product_id;
    public $article_id;
    public $quantity;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read users
    function read(){
    
        // select all query
        $query = "SELECT *  FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create user
function create(){
 
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "  (`product_id`, `article_id`, `quantity`) VALUES (:product_id, :article_id, :quantity)";
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->product_id));
    $this->description=htmlspecialchars(strip_tags($this->article_id));
    $this->price=htmlspecialchars(strip_tags($this->quantity));
 
    // bind values
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":article_id", $this->article_id);
    $stmt->bindParam(":quantity", $this->quantity);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// delete the user
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE `product_id` = :product_id AND  `article_id`= :article_id";
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->product_id));
    $this->description=htmlspecialchars(strip_tags($this->article_id));
 
    // bind values
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":article_id", $this->article_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function get_by_product_id()
{
   // delete query
   $query = "SELECT * FROM " . $this->table_name . " WHERE product_id =:product_id";
 
   // prepare query
   $stmt = $this->conn->prepare($query);

   // sanitize
   $this->product_id=htmlspecialchars(strip_tags($this->product_id));
  

   
   $stmt->bindParam(":product_id", $this->product_id);
   

  $stmt->execute();
  return $stmt;

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
/*
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
*/

function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            product_id = :product_id ,
                article_id = :article_id, 
                quantity = :quantity     
            WHERE
                id = :id";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
    $this->name=htmlspecialchars(strip_tags($this->article_id));
    $this->price=htmlspecialchars(strip_tags($this->quantity));
 
    // bind values
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":article_id", $this->article_id);
    $stmt->bindParam(":quantity", $this->quantity);
    
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;

}

}