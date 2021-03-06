<?php

/*********************
**rename this file to database.php
**********************/

class Database{

    // specify your own database credentials
    private $host = "mysql"; //or localhost
    private $db_name = "db_name";
    private $username = "root";
    private $password = "secret";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
