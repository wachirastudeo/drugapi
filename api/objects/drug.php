<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Drug
{

    // database connection and table name
    private $conn;
    private $table_name = "drug";

    // object properties
    public $id;
    public $drugname;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // read drug
    function read()
    {

        // select all query
        $query = "SELECT * FROM drug ORDER BY drugname ASC";
        // $query = "SELECT * FROM products";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    // create Drug
    function create()
    {

        $query1 = "SELECT id FROM drug ORDER BY iddrug DESC LIMIT 1";
        // prepare query statement
        $stmt1 = $this->conn->prepare($query1);

    

        // execute query
        $stmt1->execute();

        // get retrieved row
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $lastId = $row['id'];


        list($prefix,$Id) = explode('D',$lastId );
        $Id = ($Id+1);
        $new_id = 'D'.$Id;

        // query to insert record
        // $query = "INSERT INTO " . $this->table_name . " SET drugname=:drugname";
        $query = "INSERT INTO " . $this->table_name . " SET id='".$new_id."', drugname=:drugname";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->drugname = htmlspecialchars(strip_tags($this->drugname));

        // bind values
        $stmt->bindParam(":drugname", $this->drugname);


        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // used when filling up the update product form
    function readOne()
    {

        // query to read single record
        $query = "SELECT id , drugname FROM " . $this->table_name . " WHERE id = ?";
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id = $row['id'];

        $this->drugname = $row['drugname'];
    }
    function readDrugName()
    {

        // query to read single record
        $query = "SELECT drugname FROM " . $this->table_name . " WHERE id = ?";
        // prepare query statement
        // select all query

        // $query = "SELECT * FROM products";
        // prepare query statement
        $stmtdrug = $this->conn->prepare($query);

        $this->drugname = htmlspecialchars(strip_tags($this->drugname));

        // bind new values
        $stmtdrug->bindParam(':drugname', $this->drugname);
        // execute query
        $stmtdrug->execute();

        return $stmtdrug;
    }

    // update the drugname
    function update()
    {

        // update query
        $query = "UPDATE " . $this->table_name . " SET drugname = :drugname WHERE id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->drugname = htmlspecialchars(strip_tags($this->drugname));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':drugname', $this->drugname);
        $stmt->bindParam(':id', $this->id);


        // execute the query
        if ($stmt->execute()) {

            return true;
        }

        return false;
    }

    // delete the drugname
    function delete()
    {

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    // search drug
    function search($keywords)
    {

        // select all query
        $query = "SELECT  id, drugname FROM " . $this->table_name . " WHERE id LIKE ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // bind
        $stmt->bindParam(1, $keywords);


        // execute query
        $stmt->execute();

        return $stmt;
    }
}
