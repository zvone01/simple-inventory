<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
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

    include_once '../config/database.php';
    include_once '../objects/article.php';

    $database = new Database();
    $db = $database->getConnection();
    
    // prepare article object
    $article = new Article($db);
    
    // get article id
    $data = json_decode(file_get_contents("php://input"));
    
    // set article id to be deleted
    $article->id = $data->id;
    
    // delete the article
    if($article->delete()){
        echo '{';
            echo '"message": "article was deleted."';
        echo '}';
    }
    
    // if unable to delete the article
    else{
        echo '{';
            echo '"message": "Unable to delete object."';
        echo '}';
    }
//}
?>