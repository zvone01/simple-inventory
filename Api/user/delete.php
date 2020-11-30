<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/token.php';

$headers = apache_request_headers();

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
{
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);
 
// get user id
$data = json_decode(file_get_contents("php://input"));
 
// set user id to be deleted
$user->ID = $data->ID;
 
// delete the user
if($user->delete()){
    echo '{';
        echo '"message": "User was deleted."';
    echo '}';
}
 
// if unable to delete the user
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
}
?>