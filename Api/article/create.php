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
    include_once '../objects/article.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $article  = new Article($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // set article property values
    $article->name = $data->name;
    $article->description = $data->description;
    $article->price = $data->price;
    $article->stock = $data->stock;
    // create the article
    if($article->create()){
        echo '{';
            echo '"message": "article was created."';
        echo '}';
    }
    
    // if unable to create the article, tell the article
    else{
        echo '{';
            echo '"message": "Unable to create article."';
        echo '}';
    }
//}
?>