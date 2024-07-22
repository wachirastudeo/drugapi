<?php
// required headers
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object files
include_once '../config/database.php';
include_once '../objects/drug.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare drug object
$drug = new Drug($db);

// get id of drug to be edited
$data = json_decode(file_get_contents("php://input"));
// http_response_code(200);

// // tell the user
// echo json_encode(array("message" => $data->drugname ));

// set ID property of drug to be edited
$drug->id = $data->id;

// set drug property values
$drug->drugname = $data->drugname;


// update the drug
if ($drug->update()) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "drug was updated."));
}

// if unable to update the drug, tell the user
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update drug."));
}
