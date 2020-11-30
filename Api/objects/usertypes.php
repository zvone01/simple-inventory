<?php
class UserTypes{
 
    // database connection and table name
    private $conn;
    private $table_name = "usertypes";
 
    // object properties
    public $ID;
    public $Name;
    
 
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


}