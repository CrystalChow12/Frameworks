<?php 

namespace App\Controllers;

use App\Models\ApiModel;
use Framework\Validator\Validator;
use Framework\AbstractController;
use Framework\Views\View;
use Framework\Response;


class ApiController extends AbstractController {
    private ApiModel $model;
		private $token;


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

		/* API DOES NOT RENDER PAGE */

		private function setCookie(string $token) {
			setcookie('session', $token,
			[
				'path' => '/',
			]);
		}

		private function checkAuth() {
			
			if (isset($_COOKIE['session'])) {
				$token = $_COOKIE['session'];
			} else {
				$token = null;
			}
		

			 if (!$token) {
				$this->sendResponse([
					'success' => false,
					'message' => 'No token provided',
				], 401);
				return false;
			 }

			 if (!$this->model->validateToken($token)) {
				$this->sendResponse([
					'success' => false,
					'message' => 'Invalid token'
				], 401);
				return false;
			 }

			return true;
		}

	public function sendResponse($data, $statusCode) {
		$jsonContent = json_encode($data);
		$response = new Response($jsonContent, $statusCode, ['Content-Type' => 'application/json; charset=UTF-8']); 
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

		public function validateLoginCredentials(array $data) {
			if (!isset($data['email'], $data['password'])) {
				Validator::addError('request', 'Missing required fields');
				return false;
			}

			if (Validator::isEmpty($data['email']) || Validator::isEmpty($data['password'])) {
				Validator::addError('credentials', 'Email and password are required');
				return false;
			}

			if (!Validator::validEmail($data['email'])) {
				Validator::addError('email', 'Invalid email format');
				return false;
			}

			return true;
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

		private function validateToken($userId) {
			if (!$this->tokenExists($userId)){
				//insert token 
				$token = $this->generateToken();
				$this->model->insertToken($token, $userId);
				$this->setCookie($token); 
				$this->sendResponse(
					['success' => true, 'message' => 'User logged successfully through API'],
					200);
				return; 
			}

			$token = $this->tokenExists($userId);
			$expiryDate = $token['expiryDate'];

			if (!$this->model->validateToken($expiryDate)) {
				$token = $this->generateToken(); //generate a new one 
				$this->model->insertToken($token, $userId);
				//log in the user
				$this->setCookie($token);
				$this->sendResponse(
					['success' => true, 'message' => 'User logged successfully through API'], 
					200);

				return;
			}
			//if its valid, then log in user and set cookie 
			 $this->setCookie($token);
			 $this->sendResponse(['success' => true, 'message' => 'User logged successfully through API'], 200); 
			 return;
		}

		public function handleAuth(array $userData) {
			$userId = $userData['userId'];

			$this->validateToken($userId); 
			//$tokenData = $this->tokenExists($userId);
			
			// if (!$tokenData) {
			// 	$token = $this->generateToken();
			// 	$this->model->insertToken($token, $userId);
			// 	//log in the user
			// 	$this->setCookie($token);
			// 	$this->sendResponse(['success' => true, 'message' => 'User logged successfully through API'], 200);
			// 	return;
			// } else {
			// 	$this->validateToken($userId);
			// }
		}
	

    public function login() {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			Validator::addError('request', 'Bad request method');
			$errors = Validator::getErrors();
			$this->sendResponse($errors, 405); 
		}

		//get the data from the request
		$input = file_get_contents('php://input');
		$data = json_decode($input, true);
		$email = $data['email'];
		$password = $data['password'];
		$credentials= ['email' => $email, 'password' => $password];

		//validate username and pw 
		if (!$this->validateLoginCredentials($credentials)) {
			$this->sendResponse(['success'=>false, 'message' => Validator::getErrors()],400);
			return; 
		}


		//check if the user exists
		if (!$this->userExists($email, $password)) {
			Validator::addError('message', 'Invalid credentials');
			$errors = Validator::getErrors(); 
			$this->sendResponse(['success' => false, 'message' => $errors], 401);
			return; 
		}

		// clear the errors
		Validator::clearErrors();

		//handle the auth FINALLY 
		$userId = $this->userExists($email, $password);
		$credentials["userId"] = $userId;
		$this->handleAuth($credentials);
	}


	public function me() {
		if (!$this->checkAuth()) {
			return;
		}

		$this->sendResponse([
			'success' => true,
			'message' => 'this worked yay',
		], 200);
	}
    
}