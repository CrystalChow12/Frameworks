<?php

namespace App\Controllers;

use App\Guards\AuthGuard;
use Framework\AbstractController;
use App\Models\EmployeeModel;
use Framework\Validator\Validator;
use Framework\Views\View;

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

	public function index() {
		//$this->enforceRoleAccess(3);
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			Validator::addError('httpd_method', 'The request is invalid.');
			$errors = Validator::getErrors();
			$this->render('App/tpl/employee_dashboard.php', ['errors' => $errors]);
			return;
		} else {
			$employeeId = $_SESSION['userId'];
			$tasks = $this->model->getAllTasks($employeeId);
			$this->render('App/tpl/employee_dashboard.php', ['tasks' => $tasks]);
		}
	}

	public function showForm($queryParams) {
		$taskId = $queryParams['id'];
		$specificTask = $this->model->getTaskById($taskId);
		$this->render('App/tpl/edit_task.php', ['taskId' => $taskId, 'task' => $specificTask]); //this will work for rendering with the sent id
	}

	public function editTask($queryParams) {
		$taskId = $queryParams['id'];

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			return;
		}

		$status = $_POST['status'];
		$comments = $_POST['comments'];

		$this->model->editTask($taskId, $status, $comments);
		header('Location: /employee/dashboard');
	}
}
