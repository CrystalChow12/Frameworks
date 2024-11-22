<?php

namespace Framework\Service;

use PDO;
use PDOException;
use Config\Config;

class Database {



	
	private string $host = 'localhost';
	private string $user = 'root';
	private string $password = 'chowbird';
	private string $database = 'task_management_system';

	private ?PDO $connection = null;

	public function __construct() {
		$this->host = DB_HOST;
		$this->user = DB_USER;
		$this->password = DB_PASSWORD;
		$this->database = DB_NAME;

		$this->connect();
	}

	

	protected function connect() {
		try {
			//$conn = new mysqli($servername, $user, $password, $port);
			$this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

	protected function disconnect() {
		if ($this->connection) {
			$this->connection = null;
		}
	}

	public function getConnection() {
		if ($this->connection === null) {
			$this->connect();
		}
		return $this->connection;
	}
}
