<?php

namespace App\Controllers;

use App\Guards\AuthGuard;
use Framework\AbstractController;
use App\Models\AdminModel;
use Framework\Validator\Validator;
use Framework\Views\View;
use Framework\Response;

class AdminController extends AbstractController {
	private AdminModel $model;

	public function __construct(View $view) {
		parent::__construct($view);
		$this->model = new AdminModel();
		$this->enforceRoleAccess(1);
	}


	public function showForm($errors = [], $statusCode = 200) {
		$htmlcontent = $this->render('App/tpl/admin_register.php', ['errors' => $errors]);
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html']);
		$response->send();
	}

	public function index() {
		//$this->enforceRoleAccess(1);

		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->showForm($errors, 405);
			return;
		} else {
			$statistics = $this->model->getStatistics();
			$htmlcontent = $this->render('App/tpl/admin_dashboard.php', ['statistics' => $statistics]);
			$response = new Response($htmlcontent, 200, ['Content-Type' => 'text/html']);
			$response->send();
		}
	}

	

	public function getEmployees() {
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->showForm($errors, 405);
			return;
		} else {
			//save the returned result in a variable array
			$users = $this->model->getAllEmployees();

			//pass this to the view to be extracted
			$htmlcontent = $this->render('App/tpl/admin_users.php', ['users' => $users]);
			$response = new Response($htmlcontent, 200, ['Content-Type' => 'text/html']);
			$response->send();
		}
	}

	public function getTasks() {
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->showForm($errors, 405);
			return;
		} else {
			$tasks = $this->model->getAllTasks();
			$htmlcontent = $this->render('App/tpl/admin_tasks.php', ['tasks' => $tasks]);
			$response = new Response($htmlcontent, 200, ['Content-Type' => 'text/html']);
			$response->send();
		}
	}

	public function register() {
		$isValid = true;

		// check if the request method is post
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->showForm();
			return;
		}

		//get the data from the request
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = isset($_POST['role']) ? (int) $_POST['role'] : '';

		if (
			Validator::isEmpty($email) ||
			Validator::isEmpty($username) ||
			Validator::isEmpty($password) ||
			Validator::isEmpty($role)
		) {
			$isValid = false;
		}

		//validate
		if (Validator::validEmail($email) === false) {
			$isValid = false;
		}

		if ($this->model->uniqueEmail($email) === true) {
			$isValid = false;
		}

		if (Validator::validUsername($username) === false) {
			$isValid = false;
		}

		if (Validator::validPassword($password) === false) {
			$isValid = false;
		}

		if (!$isValid) {
			//get the errors from the getValidator() class
			$errors = Validator::getErrors();
			$this->showForm($errors, 400);
			return;
		}


		//if no errors then register the user
		$this->model->register($email, $username, $password, $role);
		
		Validator::$messages = ['User has been registered successfully.'];

		$messages = Validator::getMessages();

		//render the page
		$this->showForm($messages, 201);
		

		//clear the errors
		Validator::clearErrors();

		//clear success message
		Validator::$messages = [];
		
	}

	public function deleteUser($queryParams) {
		$id = $queryParams['id'];
		$this->model->deleteUser($id);
		$messages = ['User has been deleted successfully.'];
		header('Location: /admin/users');
	}
}
