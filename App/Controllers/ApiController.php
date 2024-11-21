<?php 

namespace App\Controllers;

use App\Guards\AuthGuard;
use App\Models\AuthModel;
use Framework\Validator\Validator;
use Framework\AbstractController;
use Framework\Views\View;
use Framework\Framework;
use Framework\Response;


class ApiController extends AbstractController {

    private AuthModel $model;

    public function __construct(View $view) {
    {
        parent::__construct($view);
        $this->model = new AuthModel();
    }

    
}