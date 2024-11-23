<?php

namespace App\Models;

use Framework\BaseModel;
use PDO;
use PDOException;
use Exception;
use Framework\Validator\Validator;
use Framework\Framework;

class AuthModel extends BaseModel {

	public function login($email, $password): bool {
		try {
			$query = 'SELECT Users.id, Users.email, Users.username, Users.password, Roles.id AS role_id
			FROM Users
			INNER JOIN RoleUser ON Users.id = RoleUser.userId
			INNER JOIN Roles ON RoleUser.roleId = Roles.id
			WHERE Users.email = ?';

			$stmt = $this->db->prepare($query);
			$stmt->execute([$email]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if (!$user) {
				Validator::addError('invalid_credentials', 'Invalid credentials.');
				return false;
			}

			if (password_verify($password, $user['password'])) {
				$session = Framework::getInstance()->getSession();

				$session->set('authenticated', true);
				$session->set('userId', $user['id']);
				$session->set('roleId', $user['role_id']);

				// //start the session
				// session_start();

				// //set the session variables as authenticated
				// $_SESSION['authenticated'] = true;

				// //then set a key with the user id
				// $_SESSION['userId'] = $user['id'];

				// //and another one for the user's role
				// $_SESSION['roleId'] = $user['role_id'];

				return true;
			} else {
				Validator::addError('invalid_credentials', 'Invalid credentials.');
				return false;
			}
		} catch (PDOException $e) {
			echo 'Error authenticating user: ' . $e->getMessage();
			return false;
		}
	}

	public function uniqueEmail(string $email) {
		$query = 'SELECT COUNT(*) FROM Users where email = ?;';

		try {
			$stmt = $this->db->prepare($query);
			$stmt->execute([$email]);

			$count = $stmt->fetchColumn();

			if ($count !== 0) {
				Validator::addError('email_exists', 'Email already exists.');
				return true;
			}

			return false;
		} catch (PDOException $e) {
			echo 'Error querying Database: ' . $e->getMessage();
			return false;
		}
	}


	public function register(string $email, string $username, string $password, int $role) {
		try {
			$this->db->beginTransaction();

			$userQuery = 'INSERT INTO Users (email, username, password) VALUES (?, ?, ?);';
			$userStmt = $this->db->prepare($userQuery);

			//hash the password
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$userStmt = $userStmt->execute([$email, $username, $hashedPassword]);

			$userId = $this->db->lastInsertId();

			$roleQuery = 'INSERT INTO RoleUser(userId, roleId) VALUES (?, ?);';
			$roleStmt = $this->db->prepare($roleQuery);
			$roleStmt->execute([$userId, $role]);

			

			$this->db->commit();
			return true;
		} catch (Exception $e) {
			$this->db->rollBack();
			echo 'Registration Error: ' . $e->getMessage();
		}
	}


	/*************************** API CONTROLLER FUNCTIONS *********************************************************************************************** */
	public function checkUser(string $email, string $password) {
		try {
			$query = 'SELECT Users.id, Users.email, Users.username, Users.password, Roles.id AS role_id
			FROM Users
			INNER JOIN RoleUser ON Users.id = RoleUser.userId
			INNER JOIN Roles ON RoleUser.roleId = Roles.id 
			WHERE Users.email = ?';

			$stmt = $this->db->prepare($query);
			$stmt->execute([$email]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);


				if (password_verify($password, $user['password'])) {
					$userId = $user['id'];
					return $userId;
				} else {
					return false;  
				}
			} catch (PDOException $e) {
			echo 'Error authenticating user: ' . $e->getMessage();
			return false;
		}
	}
 
	public function tokenExists($userId){
		try {
			$query = 'SELECT UserToken.token , UserToken.dateCreated, Usertoken.expiryDate FROM UserToken WHERE UserToken.userId = ?';
			$stmt = $this->db->prepare($query);
			$stmt->execute([$userId]);
			$token = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($token) {
				return $token; //return the row, therefore the token, date created and the expiry date 
			} else {
				return false; 
			}
		} catch(PDOException $e) {
			echo 'Error getting token: ' . $e->getMessage();
			return false;
		}
	}

	public function validateToken($expiryDate){
		//convert $expiryDate from datetime to date 
		$expiryDate = date_format($expiryDate,"Y-m-d"); 
		$currentDate = date("Y-m-d"); 
		if ($expiryDate > $currentDate) { //if the expiry date is more than the current date then the token is valid
			return true; //token 
		} 
		return false; 
	}
	
	public function insertToken($token, $userId) {
		$dateCreated = date('Y-m-d H:i:s');
		$expiryDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($dateCreated))); //set to only last a day 

		try {
			$query = 'INSERT INTO UserToken (userId,token, dateCreated, expiryDate) VALUES (?,?,?,?);';
			$stmt = $this->db->prepare($query);
			$stmt->execute([$userId,$token,$dateCreated,$expiryDate]); 
			return true; 
		}	catch (PDOException $e){
			echo "Error inserting token: " . $e->getMessage();
			return false; 
		}
	}
		
}
