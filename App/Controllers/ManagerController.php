<?php

namespace App\Controllers;

use Framework\AbstractController;
use App\Models\ManagerModel;
use Framework\Validator\Validator;
use Framework\Views\View;
use Framework\Response;

class ManagerController extends AbstractController {
	private ManagerModel $model;

	public function __construct(View $view) {
		parent::__construct($view);
		$this->model = new ManagerModel();
		$this->enforceRoleAccess(2);

		// //check to see if there is a session, if not it will redirect
		// //AuthGuard::redirectIfNotAuthenticated(); //wouldnt let u log in

		// if (AuthGuard::roleCheck(2)) {
		// 	header('Location: /login');
		// 	exit();
		// } //if not redirect to login page
	}

	// public function index() {
	// 	// $this->enforceRoleAccess(2);
	// 	$this->render('App/tpl/manager_dashboard.php');
	// }

	public function taskForm($errors = [], $statusCode = 200) {
		$users = $this->model->getAllEmployees();
		$htmlcontent = $this->render('App/tpl/create_task.php', ['users' => $users, 'errors' => $errors]);
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html']);
		$response->send();
	}

	//can handle errors or data 
	public function showDashboard($data = [], $statusCode = 200) {
		$htmlcontent = $this->render('App/tpl/manager_dashboard.php', ['data' => $data]);
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html']);
		$response->send();
	}

	public function viewTasks() {
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->showDashboard($errors, 405);
			//$this->render('App/tpl/manager_dashboard.php', ['errors' => $errors]);
			return;
		} else {
			$managerId = $_SESSION['userId'];
			$tasks = $this->model->getAllTasks($managerId);
			$this->showDashboard($tasks, 200);
			//$this->render('App/tpl/manager_dashboard.php', ['tasks' => $tasks]);
		}
	}

	public function assignTasks() {
		$isValid = true;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->taskForm($errors, 405);
			return;
		}

		$assigned_to = (int) $_POST['user'];
		$created_by = (int) $_SESSION['userId'];
		$due_date = date('Y-m-d', strtotime($_POST['due_date']));
		$description = $_POST['description'];

		if (Validator::isEmpty($assigned_to) || Validator::isEmpty($due_date) || Validator::isEmpty($description)) {
			$isValid = false;
		}

		if (!$isValid) {
			Validator::addError('invalid_data', 'Please fill in all the required fields.');
			$errors = Validator::getErrors();
			$this->taskForm($errors, 400);
			return;
		}

		$this->model->assignTasks($assigned_to, $created_by, $due_date, $description);
		$this->taskForm(); //maybe change this too 

		Validator::clearErrors();
	}

	public function showForm($queryParams, $statusCode = 200) {
		$taskId = $queryParams['id'];
		$users = $this->model->getAllEmployees();
		$specificTask = $this->model->getTaskById($taskId);
		$htmlcontent = $this->render('App/tpl/manager_editTask.php', ['taskId' => $taskId, 'users' => $users, 'task' => $specificTask]); //this will work for rendering with the sent id
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html']);
		$response->send();
	}

	public function editTask($queryParams) {
		$taskId = $queryParams['id'];

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->showForm($queryParams, 405);
			return;
		}

		$data = [
			'assigned_to' => $_POST['assigned_to'],
			'due_date' => $_POST['due_date'],
			'description' => $_POST['description'],
			'status' => $_POST['status'],
			// 'comments' => $_POST['comments'],
		];

		$this->model->editTask($taskId, $data);
		header('Location: /manager/dashboard');
	}
}
