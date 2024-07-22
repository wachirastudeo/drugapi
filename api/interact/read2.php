<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: *");

// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/interact.php';
  
// instantiate database and interact object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$interact = new Interact($db);
$data = json_decode(file_get_contents("php://input"));
$interact->iddrug = $data->iddrug;
$interact->idotherdrug = $data->idotherdrug;

// read interact will be here

// query interact
$stmt = $interact->readOne();
$num = 1;
  
// check if more than 0 record found
if($num>0){
  
    // interact array
    $interact_arr=array();
    $interact_arr["interact"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $interact_item=array(
            "id" => $id,
            "iddrug" => $iddrug,
            "idotherdrug" => $idotherdrug,
            "summary" => $summary,
            "severity" => $severity,
            "documentation" => $documentation,
            "clarification" => $clarification,
            "reference" => $reference
        );
  
        array_push($interact_arr["interact"], $interact_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode(array("data" =>$interact_arr));
    // show interact data in json format
    // echo json_encode($interact_arr);
}
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no interact found
    echo json_encode(
        array("status" => "No interact found.")
    );
}
  
// no interact found will be here