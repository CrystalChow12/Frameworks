<?php

namespace App\Controllers;

use App\Guards\AuthGuard;
use Framework\AbstractController;
use Framework\Views\View;

class UnauthorizedController extends AbstractController {
	public function __construct(View $view) {
		parent::__construct($view);
	}

	public function index() {
		$this->render('App/tpl/unauthorized.php');
	}
}
