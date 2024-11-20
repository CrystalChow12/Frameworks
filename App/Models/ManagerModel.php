<?php

namespace App\Models;

use Framework\BaseModel;
use PDOException;
use PDO;
use Exception;

class ManagerModel extends BaseModel {
	public function getAllEmployees() {
		try {
			$query = 'SELECT Users.id, Users.username FROM Users 
			INNER JOIN RoleUser ON Users.id = RoleUser.userId
			WHERE RoleUser.roleId=3';

			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (Exception $e) {
			echo 'Error getting all employees: ' . $e->getMessage();
			return false;
		}
	}

	public function assignTasks($assigned_to, $created_by, $due_date, $description) {
		$status = 'Pending';
		try {
			$query = 'INSERT INTO Tasks (assigned_to,created_by,due_date,description,status) VALUES (?,?,?,?,?);';

			$stmt = $this->db->prepare($query);

			$stmt->execute([$assigned_to, $created_by, $due_date, $description, $status]);

			return true;
		} catch (Exception $e) {
			echo 'Task Creation Error: ' . $e->getMessage();
		}
	}

	public function getAllTasks($managerId) {
		try {
			$query = '
            SELECT 
                Tasks.*,
                employee.username AS employee_username,
                manager.username AS manager_username
            FROM 
                Tasks
            LEFT JOIN 
                Users AS employee ON Tasks.assigned_to = employee.id
            LEFT JOIN 
                Users AS manager ON Tasks.created_by = manager.id
            WHERE 
                Tasks.created_by = ?
        ';
			$stmt = $this->db->prepare($query);
			$stmt->execute([$managerId]);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($result as &$task) {
				// Format due_date to date with no time
				if ($task['due_date']) {
					$task['due_date'] = date('Y-m-d', strtotime($task['due_date']));
				}

				// Format status
				$task['status'] = $this->formatStatus($task['status']);
			}

			return $result;
		} catch (Exception $e) {
			echo 'Error getting all tasks: ' . $e->getMessage();
			return false;
		}
	}

	public function getTaskById($taskId) {
		try {
			$query = 'SELECT * FROM Tasks WHERE id = ?';
			$stmt = $this->db->prepare($query);
			$stmt->execute([$taskId]);
			$task = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($task) {
				$task['due_date'] = date('Y-m-d', strtotime($task['due_date']));
				// $task['status'] = $this->formatStatus($task['status']);
			}

			return $task;
		} catch (Exception $e) {
			echo 'Error getting all tasks: ' . $e->getMessage();
			return false;
		}
	}

	public function editTask($taskId, $data) {
		try {
			var_dump($data);

			$query = "UPDATE Tasks 
			SET assigned_to = ?, 
				due_date = ?, 
				description = ?, 
				status = ? 
			WHERE id = ?;";

			$stmt = $this->db->prepare($query);
			$stmt->execute([$data['assigned_to'], $data['due_date'], $data['description'], $data['status'], $taskId]);

			return $stmt->rowCount() > 0;
		} catch (PDOException $e) {
			error_log('Error updating task: ' . $e->getMessage());
			return false;
		}
	}

	private function formatStatus($status) {
		switch ($status) {
			case 'In_Progress':
				return 'In Progress';
			default:
				return $status;
		}
	}
}
