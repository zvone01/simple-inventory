<?php

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
 
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/user.php';
include_once '../objects/usertypes_user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
$usertypesUser = new UserTypesUser($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));

 
// set user property values
$user->Name = $data->name;
$user->Surname = $data->surname;
$user->Username = $data->username;
$user->Email = $data->email;
$user->Password = password_hash($data->password, PASSWORD_DEFAULT);

// create the user
if($user->create())
{

    $stmt = $user->get_lastuser_id();
    if($stmt->rowCount()>0)
        {            
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
            extract($row);         
            $usertypesUser->UserID = $ID;
            }
        $usertypesUser->TypeID = $data->usertype;

        if($usertypesUser->create())
            {
             echo '{';
             echo '"message": "user was created."';
             echo '}';
            }
    else
            {
            echo '{';
            echo '"message": "Unable to create user."';
            echo '}';
            }     
        }
     
    else{
        echo json_encode(
            array("message" => "Unable to create user.")
        );
        }

}
 
else
{
    echo '{';
        echo '"message": "Unable to create user."';
    echo '}';
}

}
?>