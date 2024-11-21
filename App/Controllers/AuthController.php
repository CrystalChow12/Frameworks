<?php

namespace App\Controllers;

use App\Guards\AuthGuard;
use App\Models\AuthModel;
use Framework\Validator\Validator;
use Framework\AbstractController;
use Framework\Views\View;
use Framework\Framework;
use Framework\Response;

class AuthController extends AbstractController {
	private AuthModel $model;


	public function __construct(View $view) {
		parent::__construct($view);
		$this->model = new AuthModel();
		
	}

	// public function show($errors = []) {
	// 	// AuthGuard::redirectIfAuthenticated();
	// 	$this->render('App/tpl/login.php', ['errors' => $errors]);
	// }

	public function showRegisterForm($errors = [],$statusCode=200) {
		// View generating the html
		$htmlcontent = $this->render('App/tpl/register.php', ['errors' => $errors]); 
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html; charset=UTF-8']);
		$response->send();
	}

	public function showLoginForm($errors = [],$statusCode=200) {
		// View generating the html
		$htmlcontent = $this->render('App/tpl/login.php', ['errors' => $errors]);
		$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html; charset=UTF-8']);
		$response->send();
	}
	

	public function register() {
		$isValid = true;

		// check if the request method is post
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			Validator::addError('request', 'Bad request method');
			$errors = Validator::getErrors();
			$this->showRegisterForm($errors, 405);
			//$this->response->requestError('App/tpl/register.php', $errors);
			return;
		}

		//get the data from the request
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		$role = isset($_POST['role']) ? (int) $_POST['role'] : '';

		if (Validator::isEmpty($email) || Validator::isEmpty($username) || Validator::isEmpty($password)) {
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

		if ($password !== $confirmPassword) {
			Validator::addError('password_mismatch', 'Passwords do not match.');
			$isValid = false;
		}

		if (!$isValid) {
			//get the errors from the getValidator() classz
			$errors = Validator::getErrors();
			$this->showRegisterForm($errors,400);
			return;
		}

		// //check if the user has a role 
		// if (!isset($_SESSION['roleId']) || $_SESSION['roleId'] === '') {
		// 	$role = 3; //default to employee
		// }

		//if no errors then register the user
		$this->model->register($email, $username, $password, $role);

		//clear the errors
		Validator::clearErrors();


		//render the page
		//encapsulate this as well ?
		$htmlcontent = $this->render('App/tpl/login.php');
		$response = new Response($htmlcontent, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
		$response->send();

	}

	public function login() {
		$isValid = true;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			Validator::addError('request', 'Bad request method');
			$errors = Validator::getErrors();
			$this->showLoginForm($errors,405);
			return;
		}

		//get the data from the request
		$email = $_POST['email'];
		$password = $_POST['password'];

		//validate
		if (Validator::isEmpty($email) || Validator::isEmpty($password)) {
			$isValid = false;
		}

		if (Validator::validEmail($email) === false) {
			$isValid = false;
		}

		if (!$isValid) {
			//get the errors from the getValidator() class
			$errors = Validator::getErrors();
			$this->showLoginForm($errors,400);
			return;
		}

		//if no errors then login the user
		
		if (!$this->model->login($email, $password)) {
			//echo 'Error authenticating user.';
			$errors = Validator::getErrors();
			$this->showLoginForm($errors,401);
			
		} else {
			$response = new Response('User logged in successfully.', 200, ['Content-Type' => 'text/html; charset=UTF-8']);
			$response->send();
			AuthGuard::redirectIfAuthenticated();
		}

		// clear the errors
		Validator::clearErrors();
	}

	public function logout() {
		$session = Framework::getInstance()->getSession();
		$session->destroy();
		header('Location: /login');
	}
}
