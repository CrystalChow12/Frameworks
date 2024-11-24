<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

//should call the entry point -> framework

use Framework\Framework;

require_once 'Config/config.php';
require_once 'autoloader.php';

$framework = new Framework(dirname(__FILE__));

$router = $framework->getInstance()->getRouter();

//register
$router->addRoutes('/register', 'AuthController', 'showRegisterForm', 'GET');
$router->addRoutes('/register', 'AuthController', 'register', 'POST');

// Authentication routes
$router->addRoutes('/login', 'AuthController', 'showLoginForm', 'GET');
$router->addRoutes('/login', 'AuthController', 'login', 'POST');
$router->addRoutes('/logout', 'AuthController', 'logout', 'POST');

//admin route
$router->addRoutes('/admin', 'AdminController', 'index', 'GET');
$router->addRoutes('/admin/dashboard', 'AdminController', 'index', 'GET');
//$router->addRoutes('/admin/dashboard', 'AdminController', 'getStatistics', 'GET');

$router->addRoutes('/admin/users', 'AdminController', 'getEmployees', 'GET');
$router->addRoutes('/admin/tasks', 'AdminController', 'getTasks', 'GET');

$router->addRoutes('/admin/register', 'AdminController', 'showForm', 'GET');

$router->addRoutes('/admin/register', 'AdminController', 'register', 'POST');

$router->addRoutes('/admin/users/delete', 'AdminController', 'deleteUser', 'POST');

//manager routes
$router->addRoutes('/manager', 'ManagerController', 'viewTasks', 'GET');

$router->addRoutes('/manager/dashboard', 'ManagerController', 'viewTasks', 'GET');

$router->addRoutes('/manager/tasks/create', 'ManagerController', 'taskForm', 'GET');

$router->addRoutes('/manager/tasks/create', 'ManagerController', 'assignTasks', 'POST');

$router->addRoutes('/manager/tasks/edit', 'ManagerController', 'showForm', 'GET');

$router->addRoutes('/manager/tasks/edit', 'ManagerController', 'editTask', 'POST');

//employee routes
$router->addRoutes('/employee', 'EmployeeController', 'index', 'GET');
$router->addRoutes('/employee/dashboard', 'EmployeeController', 'index', 'GET');

$router->addRoutes('/employee/tasks/edit', 'EmployeeController', 'showForm', 'GET');

$router->addRoutes('/employee/tasks/edit', 'EmployeeController', 'editTask', 'POST');
//$router->addRoutes('/employee/edit_task', 'EmployeeController', 'editTask', 'POST');

// Error Routes
$router->addRoutes('/unauthorized', 'UnauthorizedController', 'index', 'GET');

//api routes 
$router->addRoutes('/api/login', 'ApiController', 'login', 'POST');
$router->addRoutes('/api/me', 'ApiController', 'me', 'GET');

$framework->run();