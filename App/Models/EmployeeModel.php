<?php

namespace App\Models;

use Framework\Validator\Validator;
use Exception;
use Framework\BaseModel;
use PDO;
use PDOException;

class EmployeeModel extends BaseModel {
	public function getAllTasks($employeeId) {
		try {
			//SELECT * FROM Tasks WHERE assigned_to=?;
			$query = '
            SELECT 
                Tasks.*,
                manager.username AS manager_username
            FROM 
                Tasks
            LEFT JOIN 
                Users AS manager ON Tasks.created_by = manager.id
            WHERE 
                Tasks.assigned_to = ?
            ';
			$stmt = $this->db->prepare($query);
			$stmt->execute([$employeeId]);
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

	public function editTask($taskId, $status, $comments) {
		try {
			$query = "UPDATE Tasks 
			SET status = ?,
				comments = ?
			WHERE id = ?;";

			$stmt = $this->db->prepare($query);
			$stmt->execute([$status, $comments, $taskId]);

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
