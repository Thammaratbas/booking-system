<?php

class Config
{
    private $host = 'localhost';
    private $dbname = 'login_db';
    private $username = 'root';
    private $password = '';
    protected $conn = null;

    public function __construct()
    {

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

?>