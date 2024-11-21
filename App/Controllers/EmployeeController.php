<?php

namespace App\Controllers;

use App\Guards\AuthGuard;
use Framework\AbstractController;
use App\Models\EmployeeModel;
use Framework\Validator\Validator;
use Framework\Views\View;
use Framework\Response;

class EmployeeController extends AbstractController {
	private EmployeeModel $model;

	public function __construct(View $view) {
		parent::__construct($view);
		$this->model = new EmployeeModel();

		$this->enforceRoleAccess(3);
		// //check to see if there is a session
		// //AuthGuard::redirectIfNotAuthenticated();

		// //then check to see if that session has a variable of roleId that = 3
		// if (AuthGuard::roleCheck(3)) {
		// 	header('Location: /login');
		// 	exit();
		// } //if not redirect to login page
	}

	public function showDashboard($errors = [], $statusCode = 200) {
		$htmlcontent = $this->render('App/tpl/employee_dashboard.php', ['errors' => $errors]);
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html']);
		$response->send();
	}



	public function index() {
		//$this->enforceRoleAccess(3);
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->showDashboard($errors, 405);
			return;
		} else {
			$employeeId = $_SESSION['userId'];
			$tasks = $this->model->getAllTasks($employeeId);
			$htmlcontent = $this->render('App/tpl/employee_dashboard.php', ['tasks' => $tasks]);
			$response = new Response($htmlcontent, 200, ['Content-Type' => 'text/html']);
			$response->send();
		}
	}

	public function showForm($queryParams) {
		$taskId = $queryParams['id'];
		$specificTask = $this->model->getTaskById($taskId);
		$htmlcontent = $this->render('App/tpl/edit_task.php', ['taskId' => $taskId, 'task' => $specificTask]); //this will work for rendering with the sent id
		$response = new Response($htmlcontent, 200, ['Content-Type' => 'text/html']);
		$response->send();
	}

	public function editTask($queryParams) {
		$taskId = $queryParams['id'];

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->showDashboard(405);
			return;
		}

		$status = $_POST['status'];
		$comments = $_POST['comments'];

		$this->model->editTask($taskId, $status, $comments);
		header('Location: /employee/dashboard');
	}
}
