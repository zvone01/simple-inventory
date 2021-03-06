<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/token.php';

$headers = apache_request_headers();

/*if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{
 
    http_response_code(401);
    echo json_encode(
        array("message" => "Unknown user",
              "error" => 1)
    );

}
else
{*/
 
    include_once '../config/database.php';
    include_once '../objects/product.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $product  = new Product($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // set product property values
    $product->name = $data->name;
    $product->description = $data->description;
    $product->price = $data->price;
    $product->stock = $data->stock;
    // create the product
    if($product->create()){
        echo '{';
            echo '"message": "product was created."';
        echo '}';
    }
    
    // if unable to create the product, tell the product
    else{
        echo '{';
            echo '"message": "Unable to create product."';
        echo '}';
    }
//}
?>