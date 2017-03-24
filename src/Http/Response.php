<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Http;

/**
 * Holds response data.
 * 
 * @author kkdshka
 */
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
