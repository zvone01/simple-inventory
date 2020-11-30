<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

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
 
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
$stmt = $user->read();
 
if($stmt->rowCount()>0){
 
    $users_arr=array();
    $users_arr["users"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        
        $user_item=array(
            "Username" => $Username,
            "TypeID" => $TypeID,
            );
 
        array_push($users_arr["users"], $user_item);
    }
 
    echo json_encode($users_arr);
}
 
else{
    echo json_encode(
        array("message" => "No users found.")
    );
}
}