<?php

namespace App\Models;

use Framework\BaseModel;
use PDO;
use PDOException;
use Exception;
use Framework\Validator\Validator;
use Framework\Framework;

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
