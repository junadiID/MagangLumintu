<?php

class Database
{
    // DB Params
    private $host = 'localhost';
    private $db_name = 'u7693729_lms_lessons';
    private $username = 'u7693729_lessons';
    private $password = 'u7693729_lms_lessons';
    private $conn;

    // DB Connect
    public function connect()
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    public function closeConn()
    {
        $this->conn = null;
    }
}
