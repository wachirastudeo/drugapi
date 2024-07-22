<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$drug = new Drug($db);
  
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// query products
$stmt = $drug->search($keywords);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // drug array
    $drug_arr=array();
    $drug_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $drug_item=array(
            "id" => $id,
            "name" => $name,
           
        );
  
        array_push($drug_arr["records"], $drug_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show drug data
    echo json_encode($drug_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no drug found
    echo json_encode(
        array("message" => "No drug found.")
    );
}
?>