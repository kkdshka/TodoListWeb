<?php

namespace Kkdshka\TodoListWeb\Http;

class Response {
    private $body = '';
    private $headers = [];
    
    public function setBody(string $body) {
        $this->body = $body;
    }
    
    public function setHeader(string $name, string $value) {
        $this->headers[$name] = $value;
    }
    
    public function getBody() : string {
        return $this->body;
    }
    
    public function getHeaders() : array {
        return $this->headers;
    }
}
