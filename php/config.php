<?php

class Database
{
    private $host = "localhost";
    private $dbname = "web_coba";
    private $username = "root";
    private $password = "";

    public $conn;
    public $error;

    public function connect()
    {
        $this->conn = null;
        $this->error = null;

        try
        {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            $this->error = $e->getMessage();
            $this->conn = null;
        }

        return $this->conn;
    }
}

?>