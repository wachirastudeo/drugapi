<?php

// include database and object files
include_once '../config/database.php';
include_once '../objects/drug.php';
  

  
$database = new Database();
$db = $database->getConnection();
  
$dbdrug = new Drug($db);
  
?>