<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/drug.php';
  

  
$database = new Database();
$db = $database->getConnection();
  
$drug = new Drug($db);
  
// get posted data
// $data = json_decode(file_get_contents("php://input"));
$data = $_POST['drugname'];
// make sure data is not empty
if(
    !empty($data) 
 
){
  
    // set drug property values
    $drug->drugname = $data;
   
  
    // create the drug
    if($drug->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "drug was created."));
    }
  
    // if unable to create the drug, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable"));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create drug."));
}
?>