<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Http;

/**
 * Holds session data.
 *
 * @author kkdshka
 */
class Session {
    
    private $session;
    
    public function __construct(array &$array) {
        $this->session = &$array;
    }
    
    public function set(string $key, $value) {
        $this->session[$key] = serialize($value);
    }
    
    public function get(string $key) {
        if (array_key_exists($key, $this->session)) {
            return unserialize($this->session[$key]);
        }
        throw new NotFoundException("Can't find $key.");
    }
    
    public function delete(string $key) {
        unset($this->session[$key]);
    }
    
}
 