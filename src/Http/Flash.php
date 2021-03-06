<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Http;

use InvalidArgumentException;

/**
 * Holds flash messages.
 *
 * @author kkdshka
 */
class Flash {
    
    const ERROR = 'error';
    const SUCCESS = 'success';
    
    private static $types = [
        self::ERROR,
        self::SUCCESS 
    ];
    
    private $messages = [];
    
    public function addMessage(string $type, string $message) {
        if (!in_array($type, self::$types)) {
            throw new InvalidArgumentException("Unknown type $type given.");
        }
        $this->messages[$type] = $message;
    }
    
    public function getMessages() : array {
        $messages = $this->messages;
        $this->messages = [];
        return $messages;
    }
    
}
