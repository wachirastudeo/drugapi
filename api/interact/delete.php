<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/interact.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare interact object
$interact = new Interact($db);
  
// get interact id
$data = json_decode(file_get_contents("php://input"));
  
// set interact id to be deleted
$interact->id = $data->id;
  
// delete the interact
if($interact->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "interact was deleted."));
}
  
// if unable to delete the interact
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete interact."));
}
?>