<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/interact.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$interact = new Interact($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of product to be edited
$interact->id = $data->id;
$interact->summary = $data->summary;
$interact->severity = $data->severity;
$interact->documentation = $data->documentation;
$interact->clarification = $data->clarification;
$interact->reference = $data->reference;



// update the product
if($interact->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "interact was updated."));
}
  
// if unable to update the product, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to updated ."));
}
?>