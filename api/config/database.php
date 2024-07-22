<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");

class Database
{
    private $host = "127.0.0.1";
    private $db = "dbdrug";
    private $username = "root";
    private $password = "root";
    private $port = 8889;
    private $conn;

    // get the database connection
    public function getConnection()
    {
        $this->conn = null;
        $charset = 'utf8mb4';

        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $charset . ";port=" . $this->port;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
