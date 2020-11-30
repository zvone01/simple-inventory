<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");


// include database and object files

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

$product_id = isset($_GET['ID']) ? $_GET['ID'] : die();

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$article = new Article($db);

// query users
$stmt = $article->get_by_article_id($product_id);

// check if more than 0 record found
if ($stmt->rowCount() > 0) {

    // users array
    $articles_arr = array();
    $articles_arr["articles"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $article_item = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "stock" => $stock,
            "in_one_product" => $in_one_product
        );

        array_push($articles_arr["articles"], $article_item);
    }

    echo json_encode($articles_arr);
} else {
    echo json_encode(
        array("message" => "No articles found.")
    );
}
//}
