<?php

namespace App\Models;

use Framework\BaseModel;
use PDO;
use PDOException;
use Exception;
use Framework\Validator\Validator;
use Framework\Framework;
use Datetime;

class ApiModel extends BaseModel {

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
					//$roleId = $user['role_id'];
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

	public function validateToken($token) {
		try {
				// Query to check if token exists and is valid
				$query = 'SELECT expiryDate FROM UserToken WHERE token = ?';
				$stmt = $this->db->prepare($query);
				$stmt->execute([$token]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				if (!$result) {
						return false;
				}

				// Convert database timestamp to DateTime
				$expiryDate = new DateTime($result['expiryDate']);
				$currentDate = new DateTime();

				// Compare dates
				return $expiryDate > $currentDate;
		} catch (PDOException $e) {
				error_log('Error validating token: ' . $e->getMessage());
				return false;
		}
}
	
	public function insertToken($token, $userId) {
		$dateCreated = date('Y-m-d H:i:s');
		$expiryDate = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($dateCreated))); //set to only last a day 

		try {
			$query = 'INSERT INTO UserToken (userId, token, dateCreated, expiryDate) VALUES (?,?,?,?);';
			$stmt = $this->db->prepare($query);
			$stmt->execute([$userId,$token,$dateCreated,$expiryDate]); 
			return true; 
		}	catch (PDOException $e){
			echo "Error inserting token: " . $e->getMessage();
			return false; 
		}
	}
		
}
