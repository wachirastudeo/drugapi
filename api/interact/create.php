<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
// get database connection
include_once '../config/database.php';
  
// instantiate interact object
include_once '../objects/interact.php';
  
$database = new Database();
$db = $database->getConnection();
  
$interact = new Interact($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->iddrug) &&
    !empty($data->idotherdrug)
){
  
    // set interact property values
    $interact->iddrug = $data->iddrug;
    $interact->idotherdrug = $data->idotherdrug;
    $interact->summary = $data->summary;
    $interact->severity = $data->severity;
    $interact->documentation = $data->documentation;
    $interact->clarification = $data->clarification;
    $interact->reference = $data->reference;

  
    // create the interact
    if($interact->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "interact was created."));
    }
  
    // if unable to create the interact, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create interact."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create drug. Data is incomplete."));
}
?>