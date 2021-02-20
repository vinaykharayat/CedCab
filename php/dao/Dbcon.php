<?php
/**
 * 
 */
class Dbcon
{
	public $user;
	public $source;
	public $dbPassword;
	public $database;
	public $conn;

	
	function __construct($source = 'localhost', $user = 'root', $dbPassword = '', $database = 'cedcab')
	{
		$this->source = $source;
		$this->user = $user;
		$this->dbPassword = $dbPassword;
		$this->database = $database;

		$this->conn =  new mysqli($this->source, $this->user, $this->dbPassword, $this->database);
	}
}

?>