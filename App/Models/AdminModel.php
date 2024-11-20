<?php

namespace App\Models;

use Framework\Validator\Validator;
use Exception;
use Framework\BaseModel;
use PDO;
use PDOException;

class AdminModel extends BaseModel {
	public function getAllEmployees() {
		try {
			$query = 'SELECT Users.id, Users.username, Users.email, Roles.role 
			FROM Users 
			INNER JOIN RoleUser ON USERS.id = RoleUser.userId
			INNER JOIN Roles ON ROLES.id = RoleUser.RoleId;
			';

			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (Exception $e) {
			echo 'Error getting all employees: ' . $e->getMessage();
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

	// Transaction: https://www.phptutorial.net/php-pdo/php-pdo-transaction/
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
		// if ($this->uniqueEmail($email)) {
		// 	//error
		// 	Validator::addError('email_exists', 'Email already exists.');

		// 	return false;
		// }
	}

	public function getAllTasks() {
		try {
			$query = 'SELECT * FROM Tasks;';
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			//format due_date to date and no time
			foreach ($result as $key => $value) {
				$result[$key]['due_date'] = date('Y-m-d', strtotime($result[$key]['due_date']));
			}

			return $result;
		} catch (Exception $e) {
			echo 'Error getting tasks: ' . $e->getMessage();
			return false;
		}
	}

	public function getStatistics() {
		try {
			$query = 'SELECT
			COUNT(*) AS totalTasks,
			SUM(CASE WHEN status = \'Pending\' THEN 1 ELSE 0 END) AS pendingTasks,
			SUM(CASE WHEN status = \'Completed\' THEN 1 ELSE 0 END) AS completedTasks
			FROM Tasks;';

			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (Exception $e) {
			echo 'Error getting task statistics: ' . $e->getMessage();
		}
	}

	public function deleteUser($id) {
		try {
			// We must do a transaction instead of just running the delete query
			// because we need to delete the related records in the RoleUser table first before deleting the user
			// or we get this error:
			//SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (task_management_system.roleuser, CONSTRAINT RoleUser_userId_fkey FOREIGN KEY (userId) REFERENCES users (id) ON DELETE RESTRICT ON UPDATE CASCADE)
			$this->db->beginTransaction();
	
			//delete related records in the RoleUser table
			$queryRoleUser = 'DELETE FROM RoleUser WHERE userId = ?';
			$stmtRoleUser = $this->db->prepare($queryRoleUser);
			$stmtRoleUser->execute([$id]);
	
			//delete the user from the Users table
			$queryUser = 'DELETE FROM Users WHERE id = ?';
			$stmtUser = $this->db->prepare($queryUser);
			$stmtUser->execute([$id]);
	
			$this->db->commit();
			return true;
		} catch (Exception $e) {
			$this->db->rollBack();
			error_log('Error deleting user: ' . $e->getMessage());
			return false;
		}
	}
}
