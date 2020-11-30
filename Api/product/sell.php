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
include_once '../objects/article.php';
include_once '../objects/article_ledger_entry.php';

$database = new Database();
$db = $database->getConnection();

$product  = new Product($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
$response = [];
$product->id = $data->id;
$quantity_to_sell = $data->quantity;
if(!$product->get_available_num()) {
    $response['message'] ="Product not exist";
    return  print_r(json_encode($response));
}
if($product->stock < $quantity_to_sell) {
    $response['message'] ="Product quantity not available";
    return  print_r(json_encode($response));
}
// query users
$stmt = $product->get_articles();

// check if more than 0 record found
if ($stmt->rowCount() > 0) {

    // users array
    $articles_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        if ($stock < $quantity) {
            $response['message'] = "No available product.";
            return print_r(json_encode($response));
        }
        array_push($articles_arr, array(
            "id" => $id,
            "quantity" => $quantity
        ));
    }
    $ale = new Ale($db);
    foreach ($articles_arr as $art) {
        
        $ale->article_id = $art['id'];
        $ale->quantity =-$art['quantity']*$quantity_to_sell ;
        $ale->document_no = "sell product id:". $product->id;
        if ($ale->create()) {
            $response['message'] = true;
        } else {
            $response['message'] = false;
        }
    }
} else {
    $response['message'] = "No products found.";
}

print_r(json_encode($response));
//}
