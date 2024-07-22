<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/drug.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare drug object
$drug = new Drug($db);
  
// set ID property of record to read
$drug->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of product to be edited
$drug->readOne();
  
if($drug->drugname!=null){
    // create array
    $drug_arr = array(
        "id" =>  $drug->id,
        "drugname" => $drug->drugname
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($drug_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user drug does not exist
    echo json_encode(array("message" => "drug does not exist."));
}
?>