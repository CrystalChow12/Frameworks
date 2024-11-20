<?php
namespace Framework;

use App\Guards\AuthGuard;
use Framework\Views\View;

abstract class AbstractController {
	private View $view;
	//protected ResponseController $response;

	public function __construct(View $view) {
		$this->view = $view;
		$this->response = new ResponseController($view);
	}

	protected function enforceRoleAccess(int $requiredRole) {
		AuthGuard::redirectIfNotAuthenticated();
	

		if (!AuthGuard::roleCheck($requiredRole)) {
			$userRole = $_SESSION['roleId'];
			// Capture the current URL (path + query)
			switch ($userRole):
				case 1:
					$redirectTo = '/admin/dashboard';
					break;
				case 2:
					$redirectTo = '/manager/dashboard';
					break;
				case 3:
					$redirectTo = '/employee/dashboard';
					break;
				default:
					$redirectTo = '/login';
					break;
			endswitch;

			$currentPath = urlencode($redirectTo);

			// Redirect to unauthorized page with the redirectTo param
			header('Location: /unauthorized?redirectTo=' . $currentPath);
			exit();
		}
	}

	//can be used in the base controller class and the child controllers
	protected function render(string $template, array $data = []) {
		//return the view that was created and return the render method in the view class
		return $this->view->render($template, $data);
	}

	protected function json(array $data) {
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}
