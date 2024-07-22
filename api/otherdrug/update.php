<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/otherdrug.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare drug object
$otherdrug = new Otherdrug($db);
  
// get id of drug to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of drug to be edited
$otherdrug->id = $data->id;
  
// set drug property values
$otherdrug->otherdrug = $data->otherdrugname;

  
// update the drug
if($otherdrug->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "otherdrug was updated."));
}
  
// if unable to update the drug, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update otherdrug."));
}
?>