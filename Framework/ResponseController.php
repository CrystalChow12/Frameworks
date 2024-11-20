<?php 

namespace Framework;
use Framework\Views\View;

class ResponseController extends AbstractController {
    private $statusCode; //200 or 404 or 500
    private $data; //data pulled from the database
    private $message; //success or failed 
    //private $errors = []; //errors //errors pulled from the validator

    public function __construct(View $view) {
        parent::__construct($view);
    }
    
    // $errors = Validator::getErrors();
	// $this->render('App/tpl/admin_register.php', ['errors' => $errors]);

    public function setCode($code) {
        $this->statusCode = $code;
        http_response_code($this->statusCode);
    }
    
    public function errorResponse(string $path,array $errors) {
        $this->render($path, ['errors' => $errors]);
        //set the status code to 400
        http_response_code(400);
        //$this->setCode(400);
    }
    
}