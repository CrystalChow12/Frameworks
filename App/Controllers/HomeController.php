<?php

namespace App\Controllers;

use Framework\AbstractController;

class HomeController extends AbstractController {
	public function index() {
		echo 'hello from home controller';
	}

	public function show() {
		$this->render('App/tpl/login.php');
	}
}
