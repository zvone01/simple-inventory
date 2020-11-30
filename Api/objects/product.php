<?php
class Product
{

    // database connection and table name
    private $conn;
    private $table_name = "product";
    private $table_productarticle_name = "product_article";
    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $stock;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // read users
    function read()
    {

        // select all query
        $query = "SELECT *  FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create user
    function create($returnid = false)
    {

        // query to insert record
        $query = "INSERT INTO
               " . $this->table_name . " SET Name=:Name, Description=:Description";
        $query = "INSERT INTO " . $this->table_name . "  (`id`, `name`, `price`, `description`, `stock`) VALUES (:id, :name, :price, :description, :stock)";
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->stock = htmlspecialchars(strip_tags($this->stock));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":stock", $this->stock);

        // execute query
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }


    // delete the user
    function delete()
    {

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE `id` = ?";
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->ID = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
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
        $this->name = htmlspecialchars(strip_tags($this->name));



        $stmt->bindParam(":name", $this->name);


        $stmt->execute();
        return $stmt;
    }

    function get_by_id()
    {

        $this->id = htmlspecialchars(strip_tags($this->id));

        // query to read single record
        $query = "SELECT *  FROM " . $this->table_name . " WHERE id = " . $this->id;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        if ($stmt->rowCount() < 1)
            return false;
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // set values to object properties
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->stock = $row['stock'];
        return true;
    }


    function update()
    {

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
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->stock = htmlspecialchars(strip_tags($this->stock));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":stock", $this->stock);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function add_article($article_id, $quantity)
    {

        // query to insert record
        $query = "INSERT INTO `" . $this->table_productarticle_name . "`  (`product_id`, `article_id`, `quantity`) VALUES (:product_id, :article_id, :quantity)";
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $article_id = htmlspecialchars(strip_tags($article_id));
        $quantity = htmlspecialchars(strip_tags($quantity));

        // bind values
        $stmt->bindParam(":product_id", $this->id);
        $stmt->bindParam(":article_id", $article_id);
        $stmt->bindParam(":quantity", $quantity);


        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function get_all_with_available_num()
    {
        $query = "SELECT \n"
            . "p.id,\n"
            . "p.name,\n"
            . "p.price,\n"
            . "p.description,\n"
            . "MIN(FLOOR(a.stock / pa.quantity)) as \"stock\" \n"
            . "FROM `product` p \n"
            . "Join product_article pa \n"
            . "on p.id = pa.product_id\n"
            . "Join article a \n"
            . "on a.id = pa.article_id\n"
            . "group by p.id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function get_all_available()
    {
        $query = "SELECT \n"
            . "p.id,\n"
            . "p.name,\n"
            . "p.price,\n"
            . "p.description,\n"
            . "MIN(FLOOR(a.stock / pa.quantity)) as \"stock\" \n"
            . "FROM `product` p \n"
            . "Join product_article pa \n"
            . "on p.id = pa.product_id\n"
            . "Join article a \n"
            . "on a.id = pa.article_id\n"
            . "group by p.id"
            . " having stock > 0";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function get_available_num()
    {
        $query = "SELECT \n"
            . "p.id,\n"
            . "p.name,\n"
            . "p.price,\n"
            . "p.description,\n"
            . "MIN(FLOOR(a.stock / pa.quantity)) as \"available\" \n"
            . "FROM `product` p \n"
            . "Join product_article pa \n"
            . "on p.id = pa.product_id\n"
            . "Join article a \n"
            . "on a.id = pa.article_id\n"
            . "WHERE p.id =?"
            . "group by p.id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->ID = htmlspecialchars(strip_tags($this->id));

        // bind id of record to select
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        if ($stmt->rowCount() < 1)
            return false;
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // set values to object properties
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->stock = $row['available'];
        return true;
    }

    /*
    * gets all articles of product
    * returns article id, name, stock, and quantity in product
    */
    function get_articles()
    {
        $query = "SELECT a.id, a.name,  a.stock, pa.quantity \n"
            . "FROM `product` p \n"
            . "JOIN product_article pa On p.id = pa.product_id\n"
            . "join article a  on a.id = pa.article_id\n"
            . "Where p.id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->ID = htmlspecialchars(strip_tags($this->id));

        // bind id of record to select
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
