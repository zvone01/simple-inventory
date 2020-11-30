<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");


// include database and object files

include_once '../config/token.php';

$headers = apache_request_headers();
/*
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
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
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);

// query users
$stmt = $product->get_all_available();

// check if more than 0 record found
if ($stmt->rowCount() > 0) {

    // users array
    $products_arr = array();
    $products_arr["products"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "stock" => $stock
        );

        array_push($products_arr["products"], $product_item);
    }

    echo json_encode($products_arr);
} else {
    echo json_encode(
        array("message" => "No products found.")
    );
}
//}
