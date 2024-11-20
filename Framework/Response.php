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
    
    public function errorResponse(string $path,array $errors) {

        $this->view->render($path, ['errors' => $errors]);
        //set the status code to 400
        http_response_code(400);
        //$this->setCode(400);
    }
    
}