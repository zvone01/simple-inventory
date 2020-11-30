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

    $database = new Database();
    $db = $database->getConnection();
    
    $product  = new Product($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    $response = [];
    foreach(  $data->products as $item )
    {
        $product->id =null;
        $product->name = $item->name;

        if($product->create()){
            foreach($item->contain_articles as $article) 
            {
                
                if($product->add_article($article->art_id,$article->amount_of)  )
                {
                    $response["message"][$item->name][$article->art_id] = true;
                    
                } else {
                    $response["message"][$item->name][$article->art_id] = false;
                }
            }
            $response["message"][$item->name] = true;
        } else {
            
            $response["message"][$item->name]= false;
        }
    }
    print_r(json_encode($response));
//}
?>