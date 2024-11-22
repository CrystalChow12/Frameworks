<?php 

namespace Framework;


final class Response {
    //content, status and headers 
    private mixed $content = null;
    //private int $statusCode = 200; //successful by default
    private int $statusCode; //successful by default
    private array $headers = [];

    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
    // Picked the most used ones
    private const HTTP_RESPONSE_MESSAGES = [
        200 => 'OK',
        201 => 'Created',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    public function __construct($content, $statusCode, $headers){
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    // https://www.php.net/manual/en/function.header.php
    private function sendHeaders() {
        if (headers_sent()) {
            return;
        }

        http_response_code($this->statusCode);

        if(isset(self::HTTP_RESPONSE_MESSAGES[$this->statusCode])) {
            header("HTTP/1.1 {$this->statusCode} " . self::HTTP_RESPONSE_MESSAGES[$this->statusCode]);
        }

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }


    public function send() {

        $this->sendHeaders();

        if ($this->content !== null) {
            echo $this->content;
        }
    }
    
}