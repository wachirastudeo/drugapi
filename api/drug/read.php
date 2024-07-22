<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  ;
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/drug.php';
  
// instantiate database and drug object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$drug = new Drug($db);
  
// read drug will be here

// query drug
$stmt = $drug->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // drug array
    $drug_arr=array();
    $drug_arr["drug"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $drug_item=array(
            "id" => $id,
            "drugname" => $drugname,
         
        );
  
        array_push($drug_arr["drug"], $drug_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show drug data in json format
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
  
// no drug found will be here