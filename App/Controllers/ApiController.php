<?php 

namespace App\Controllers;

use App\Guards\AuthGuard;
use App\Models\ApiModel;
use App\Models\AuthModel;
use Framework\Validator\Validator;
use Framework\AbstractController;
use Framework\Views\View;
use Framework\Framework;
use Framework\Response;


class ApiController extends AbstractController {
    private ApiModel $model;


	public function __construct(View $view) {
		parent::__construct($view);
		$this->model = new ApiModel();
    }

		/*
		1. check if user exists in Users table 
		2. if user exists, then check to see if they have a token
		3. if they have a token, log in 
		4. if no token, then generate a token and then log in 



		entering user in User token table:
		1. get the ID of the user in the USER table 
		2. insert the token 
		*/


    public function showLoginForm($errors = [],$statusCode=200) {
			// View generating the html
			$htmlcontent = $this->render('App/tpl/login.php', ['errors' => $errors]);
			$response = new Response($htmlcontent, $statusCode, ['Content-Type' => 'text/html; charset=UTF-8']);
			$response->send();
	}

	public function userExists($username, $password) {
		if (!$this->model->checkUser($username, $password)) {
			return false;
		}
		//return userId and roleId
		$userId = $this->model->checkUser($username, $password); //get userId returned
		return $userId;
    }

	public function tokenExists($userId){
		if (!$this->model->tokenExists($userId)) {
			return false;
		}
		$token = $this->model->tokenExists($userId);
		return $token;
	}


    public function generateToken() {
		$token = bin2hex(random_bytes(32));
		return $token;
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

		//check if the user exists
		if (!$this->userExists($email, $password)) {
			Validator::addError('invalid_credentials', 'Invalid credentials');
			$errors = Validator::getErrors();
			$this->showLoginForm($errors, 401);
			return; 
		}

		
		// clear the errors
		Validator::clearErrors();

		//check if the token exists
		$userId = $this->userExists($email, $password);
		if (!$this->tokenExists($userId)) {
			//generate a token
			$token = $this->generateToken();
			$this->model->insertToken($token, $userId);
			//log in the user
			$response = new Response('User logged in successfully.', 200, ['Content-Type' => 'text/html; charset=UTF-8']);
			$response->send();
			AuthGuard::redirectIfAuthenticated();
			return;
		} else {
			//validate the token 
			$token = $this->tokenExists($userId);
			$expiryDate = $token['expiryDate'];
			
			if (!$this->model->validateToken($expiryDate)) { //if  token expired, insert a new one
				$token = $this->generateToken();
				$this->model->insertToken($token, $userId);

				//log in the user
				$response = new Response('User logged in successfully.', 200, ['Content-Type' => 'text/html; charset=UTF-8']);
				$response->send();
				AuthGuard::redirectIfAuthenticated();

				return;
			} else {
				//token valid, log in user 
				$response = new Response('User logged in successfully.', 200, ['Content-Type' => 'text/html; charset=UTF-8']);
				$response->send();
				AuthGuard::redirectIfAuthenticated();
				return;
			}
		}
	}

    
}