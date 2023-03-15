<?php

class Database
{
    private $host, $user, $pass, $conn;

    public function __construct($host = "", $user = "", $pass = "", $conn = "")
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->conn = $conn;
    }

    public function conn()
    {
        ($db = new mysqli($this->host, $this->user, $this->pass, $this->conn)) or
            die("Connection failed: " . $db->connect_error);

        return $db;
    }

    public function close()
    {
        $this->close();
    }
}
