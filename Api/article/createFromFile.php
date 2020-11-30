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
    include_once '../objects/article_ledger_entry.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $article  = new Article($db);
    $ale = new Ale($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $response = [];
    foreach(  $data->inventory as $item )
    {
        
        //print_r(json_encode($item));
        // set article property values
        $article->id = $item->art_id;
        $article->name = $item->name;
        //$article->description = $item->description;
        //$article->price = $item->price;
        $article->stock = 0;
        //create article
        if($article->create()){

            //update stock quantity
            $ale->article_id = $article->conn->lastInsertId();
            $ale->quantity = $item->stock;
            $ale->document_no = "import from file";
            if ($ale->create()) {
                $response['message'][$item->art_id] = true;
            } else {
                $response['message'][$item->art_id] = false;
            }
        } else {
            
            $response["message"][$item->art_id]= false;
        }
    }
    print_r(json_encode($response));
//}
?>