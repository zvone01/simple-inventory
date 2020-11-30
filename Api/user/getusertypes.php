<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");



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
include_once '../objects/usertypes.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$usertypes = new UserTypes($db);
 
// query users
$stmt = $usertypes->read();
 
// check if more than 0 record found
if($stmt->rowCount()>0){
 
    // users array
    $usertypes_arr=array();
    $usertypes_arr["usertypes"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        
        $usertype_item=array(
            "ID" => $ID,
            "Name" => $Name
            );
 
        array_push($usertypes_arr["usertypes"], $usertype_item);
    }
 
    echo json_encode($usertypes_arr);
}
 
else{
    echo json_encode(
        array("message" => "No usertypes found")
    );
}
}
?>