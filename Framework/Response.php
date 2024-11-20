<?php 

namespace Framework;
use Framework\Views\View;


class Response {
    private View $view;
    private $statusCode; //200 or 404 or 500
    private $data; //data pulled from the database
    private $message; //success or failed 
    //private $errors = []; //errors //errors pulled from the validator

    public function __construct(View $view) {
        $this->view = $view;
    }
    
    // $errors = Validator::getErrors();
	// $this->render('App/tpl/admin_register.php', ['errors' => $errors]);

    public function setCode($code) {
        $this->statusCode = $code;
        http_response_code($this->statusCode);
    }
    
    //this error response is for validation errors, such as wrong email or password mismatch 
    public function clientError(string $path, array $errors) {
        $this->view->render($path, ['errors' => $errors]);
        http_response_code(422); 
    }

    public function authError(string $path, array $errors) {
        $this->view->render($path, ['errors' => $errors]);
        http_response_code(401);
    }

    //response is for when the request method is not correct
    public function requestError(string $path, array $errors) {
        $this->view->render($path, ['errors' => $errors]);
        http_response_code(405);
    }
}