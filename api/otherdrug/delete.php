<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/otherdrug.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare drug object
$otherdrug = new Otherdrug($db);
  
// get drug id
$data = json_decode(file_get_contents("php://input"));
  
// set drug id to be deleted
$otherdrug->id = $data->id;
  
// delete the drug
if($otherdrug->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "otherdrug was deleted."));
}
  
// if unable to delete the drug
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete otherdrug."));
}
?>