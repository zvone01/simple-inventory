<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
    
    
    // get database connection
    include_once '../config/database.php';
    
    // instantiate user object
    include_once '../objects/article_ledger_entry.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    $ale = new Ale($db);
    //update stock quantity
    $ale->article_id = $data->id;
    $ale->quantity = $data->stock;
    $ale->document_no = "update";
    if ($ale->create()) {
        $response['message']= "updated";
    } else {
        $response['message'] ="error";
    }
    
    print_r(json_encode($response));
//}
