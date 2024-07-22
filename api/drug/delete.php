<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
// database connection will be here
// include database and object file
include_once '../config/database.php';
include_once '../objects/drug.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare drug object
$drug = new Drug($db);
  
// get drug id
$data = $_POST['id'];  
// set drug id to be deleted
$drug->id = $data;
    // http_response_code(200);

    //   echo json_encode(array("message" =>$drug->id));

// delete the drug
if($drug->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "drug was deleted."));
}
  
// if unable to delete the drug
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete drug."));
}
