<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
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


// include database and object files
include_once '../config/database.php';
include_once '../objects/article.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$article = new Article($db);

$article->id = isset($_GET['ID']) ? $_GET['ID'] : die();
// read the details of article
if($article->get_by_id()){
    // make it json format
    print_r(json_encode($article));
}
// if unable to create the article, tell the user
else{
    echo '{';
        echo '"message": "Unable to find article."';
    echo '}';
}

//}
