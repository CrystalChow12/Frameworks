<?php

namespace Framework;

use Framework\Views\View;
use Exceptions\RouteNotFoundException;

class Router {
	private array $routes = [];
	private View $view;
	private string $controllerNamespace = 'App\\Controllers\\';
	private $seperators = ['/', '\\'];

	public function __construct(View $view) {
		$this->view = $view;
		$this->routes = [];
	}

	public function addRoutes(string $path, string $ctrl, string $method, string $httpMethod) {
		$path = $this->normalizePath($path);
		$this->routes[$path][$httpMethod] = [
			'controller' => $ctrl,
			'method' => $method,
		];
	}

	public function route(string $path, string $method) {
		$request_uri = explode('?', $path); // ? extracts what is after the ? in a url, & for multiple params
		$path = $request_uri[0];
		$queryString = isset($request_uri[1]) ? $request_uri[1] : ''; //if empty, will return an empty array
		$queryParams = [];
		parse_str($queryString, $queryParams);

		$path = $this->normalizePath($path);

		if (!isset($this->routes[$path][$method])) {
			throw new RouteNotFoundException("No route found for $method $path");
		}

		return $this->dispatch($this->routes[$path][$method], $queryParams);
	}

	//private so that it prevents user access
	private function normalizePath(string $path) {
		$path = parse_url($path, PHP_URL_PATH);
		$path = trim($path, '/');
		if ($path === '') {
			return '/';
		}
		return '/' . $path;
	}

	private function dispatch(array $route, array $queryParams) {
		$controllerName = $route['controller'];
		$methodName = $route['method'];

		$fullControllerName = $this->controllerNamespace . $controllerName;

		if (!class_exists($fullControllerName)) {
			throw new RouteNotFoundException("Controller $controllerName not found");
		}

		$controller = new $fullControllerName($this->view);

		if (!method_exists($controller, $methodName)) {
			throw new RouteNotFoundException("Method $methodName not found in controller: " . get_class($controller));
		}

		$controller->$methodName($queryParams);
	}
}
