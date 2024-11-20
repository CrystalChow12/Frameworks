<?php

//entry point for my framework
namespace Framework;

use Framework\Router;
use Framework\Views\View;
use Exceptions\RouteNotFoundException;
use Framework\Service\Database;
use Framework\SessionManager;

class Framework {
	public static string $ROOTDIR;

	private Router $router;

	public static Framework $instance;

	private View $view;

	private Database $database;

	private SessionManager $session;


	public function __construct($rootPath) {
		self::$ROOTDIR = $rootPath;
		self::$instance = $this;
		$this->database = new Database('localhost', 'root', 'chowbird', 'task_management_system');
		$this->view = new View();
		$this->router = new Router($this->view);
		$this->session = new SessionManager(); 
		$this->session->start(); //ensures that a session is always established no matter wat page 
	}

	//sends the request to the router
	//you can get the http method using request method
	public function run() {
		try {
			$method = $_SERVER['REQUEST_METHOD'];
			$path = $_SERVER['REQUEST_URI'];

			$this->router->route($path, $method);
		} catch (\Exception $e) {
			$this->handleException($e);
		}
	}

	public function handleException(\Exception $e) {
		if ($e instanceof RouteNotFoundException) {
			header('HTTP/1.1 404 Not Found');
			echo json_encode(['status_code' => '404', 'message' => '404 not found']);
			throw $e;
		} else {
			header('HTTP/1.1 500 Internal Server Error');
			echo json_encode(['status_code' => '500', 'message' => 'Internal Server Error']);
		}
	}

	public static function getInstance() {
		return self::$instance;
	}

	public function getRouter() {
		return $this->router; //return instance of router
	}

	public function getDatabase() {
		return $this->database; //return the instance of the database connection
	}

	public function getSession() { //getting the instance of session 
		return $this->session;
	}
}
