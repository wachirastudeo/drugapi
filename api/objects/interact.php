<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Interact
{

    // database connection and table name
    private $conn;
    private $table_name = "interact";

    // object properties
    public $iddrug;
    public $idotherdrug;
    public $summary;
    public $severity;
    public $documentation;
    public $clarification;
    public $reference;

  

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // read drug
    function read()
    {

        // select all query
        $query = "SELECT * FROM drug";
        // $query = "SELECT * FROM products";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    // create Drug
function create(){
  
    // query to insert record
    $query = "INSERT INTO ".$this->table_name." SET iddrug=:iddrug ,idotherdrug=:idotherdrug ,summary=:summary,severity=:severity,documentation=:documentation,clarification=:clarification,reference=:reference";
    // ,summary=:summary,severity=:severity,documentation=:documentation,clarification=:clarification,reference=:reference
    // prepare query
    $stmt = $this->conn->prepare($query);
  
     // sanitize
     $this->iddrug=htmlspecialchars(strip_tags($this->iddrug));
     $this->idotherdrug=htmlspecialchars(strip_tags($this->idotherdrug));
     $this->summary=htmlspecialchars(strip_tags($this->summary));
     $this->severity=htmlspecialchars(strip_tags($this->severity));
     $this->documentation=htmlspecialchars(strip_tags($this->documentation));
     $this->clarification=htmlspecialchars(strip_tags($this->clarification));
     $this->reference=htmlspecialchars(strip_tags($this->reference));

     // bind values
     $stmt->bindParam(":iddrug", $this->iddrug);
     $stmt->bindParam(":idotherdrug", $this->idotherdrug);
     $stmt->bindParam(":summary", $this->summary);
     $stmt->bindParam(":severity", $this->severity);
     $stmt->bindParam(":documentation", $this->documentation);
     $stmt->bindParam(":clarification", $this->clarification);
     $stmt->bindParam(":reference", $this->reference);


    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// used when filling up the update product form
function readOne(){
    // query to read single record
    $query = "SELECT * FROM ".$this->table_name." WHERE iddrug=:iddrug AND idotherdrug=:idotherdrug";
    // prepare query statement
     // select all query
    
     // $query = "SELECT * FROM products";
     // prepare query statement
     $stmt = $this->conn->prepare($query);

     $this->iddrug=htmlspecialchars(strip_tags($this->iddrug));
     $this->idotherdrug=htmlspecialchars(strip_tags($this->idotherdrug));
 
     // bind new values
     $stmt->bindParam(':iddrug', $this->iddrug);
     $stmt->bindParam(':idotherdrug', $this->idotherdrug);
     // execute query
     $stmt->execute();

     return $stmt;

     
}

// update the drugname
function update(){
  
    // update query
    $query = "UPDATE ".$this->table_name." SET summary = :summary ,severity = :severity ,documentation = :documentation ,clarification = :clarification ,reference = :reference  WHERE id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->summary=htmlspecialchars(strip_tags($this->summary));
    $this->severity=htmlspecialchars(strip_tags($this->severity));
    $this->documentation=htmlspecialchars(strip_tags($this->documentation));
    $this->clarification=htmlspecialchars(strip_tags($this->clarification));
    $this->reference=htmlspecialchars(strip_tags($this->reference));

    // bind new values
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':summary', $this->summary);
    $stmt->bindParam(':severity', $this->severity);
    $stmt->bindParam(':documentation', $this->documentation);
    $stmt->bindParam(':clarification', $this->clarification);
    $stmt->bindParam(':reference', $this->reference);

    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

// delete the drugname
function delete(){
  
    // delete query
    $query = "DELETE FROM ".$this->table_name." WHERE id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// search drug
function search($keywords){
  
    // select all query
    $query = "SELECT  id, drugname FROM ".$this->table_name." WHERE id LIKE ?";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
   
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
