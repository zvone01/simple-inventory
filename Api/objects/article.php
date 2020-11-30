<?php
class Article{
 
    // database connection and table name
    public $conn;
    private $table_name = "article";
 
    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $stock;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read articles
    function read(){
    
        // select all query
        $query = "SELECT *  FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create article
function create($return_id = false){
 
    // query to insert record
    $query = "INSERT INTO " . $this->table_name . "  (`id`, `name`, `price`, `description`, `stock`) VALUES (:id, :name, :price, :description, :stock)";
    // prepare query
    $stmt = $this->conn->prepare($query);
 

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->stock=htmlspecialchars(strip_tags($this->stock));
     
        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":stock", $this->stock);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// delete the article
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE `id` = ?";
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->ID=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function get_by_name()
{
   // delete query
   $query = "SELECT * FROM " . $this->table_name . " WHERE name =:name";
 
   // prepare query
   $stmt = $this->conn->prepare($query);

   // sanitize
   $this->name=htmlspecialchars(strip_tags($this->name));
  

   
   $stmt->bindParam(":name", $this->name);
   

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

function get_by_article_id($article_ID){
 
    $article_ID=htmlspecialchars(strip_tags($article_ID));

    // query to read single record
    $query = "SELECT a.id, a.name, a.price, a.description, a.stock, pa.quantity as 'in_one_product' FROM article a JOIN product_article pa on a.id = pa.article_id WHERE pa.product_id = " . $article_ID ;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}


function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name ,
                price = :price, 
                description = :description, 
                stock = :stock        
            WHERE
                id = :id";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->stock=htmlspecialchars(strip_tags($this->stock));
 
    // bind values
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":stock", $this->stock);
    
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;

}


function update_stock($quantity){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                `stock` = `stock` + :stock        
            WHERE
                id = :id";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->stock=htmlspecialchars(strip_tags($this->stock));
 
    // bind values
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":stock", $quantity);
    
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;

}

}