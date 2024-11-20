<?php

namespace App\Guards;

use Framework\Framework;

class AuthGuard {
	public static function check() {
		$session = Framework::getInstance()->getSession(); //get instance of session from framework

		if (!$session->has('authenticated') && $session->get('authenticated') === false) {
			return false;
		}

		return true;

		//return $session->has('authenticated') && $session->get('authenticated') === true;
	}

	public static function roleCheck(int $requiredRole) {
		if (!AuthGuard::check()) {
			return false;
		}

		$session = Framework::getInstance()->getSession();
		$userRole = $session->get('roleId');

		if ($requiredRole === $userRole) {
			return true;
		}

		return false;
	}

	public static function redirectIfNotAuthenticated() {
		$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		if ($currentPath === '/login') {
			return;
		}

		if (!AuthGuard::check()) {
			header('Location: /login');
			exit();
		}
	}

	public static function redirectIfAuthenticated() {
		if (AuthGuard::check()) {
			$session = Framework::getInstance()->getSession();
			$userRole = $session->get('roleId');

			switch ($userRole) {
				case 1:
					$redirectTo = '/admin/dashboard';
					break;
				case 2:
					$redirectTo = '/manager/dashboard';
					break;
				case 3:
					$redirectTo = '/employee/dashboard';
					break;
			}

			header("Location: $redirectTo");
			exit();
		}
	}
}

//Middle ware
//anything that happens between the request and the response
//a service that can be useful in multiple situations and in this case a controller?
//next middleware is the nexxt middleware to be called
//runs in the order that you define it and runs before any request
