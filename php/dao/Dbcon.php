<?php

/**
 * 
 */
abstract class Dbcon {

    private $user;
    private $source;
    private $dbPassword;
    private $database;
    protected $conn;

    protected function createConnection($source = 'localhost', $user = 'root', $dbPassword = '', $database = 'cedcab') {
        $this->source = $source;
        $this->user = $user;
        $this->dbPassword = $dbPassword;
        $this->database = $database;
        $this->conn = new mysqli($this->source, $this->user, $this->dbPassword, $this->database);
    }

    abstract function getConn();
}

?>