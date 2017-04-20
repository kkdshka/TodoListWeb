<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Authentification;

use Kkdshka\TodoList\Model\User;
use Kkdshka\TodoListWeb\Http\Session;
use Kkdshka\TodoListWeb\Http\NotFoundException;

/**
 * Holds User in session.
 *
 * @author kkdshka
 */
class SessionUserStorage implements UserStorage {
    
    private $session;
    
    public function __construct(Session $session) {
        $this->session = $session;
    }
    
    public function setUser(User $user) {
        $this->session->set('user', $user);
    }
    
    public function getUser() : User {
        try {
            return $this->session->get('user');
        }
        catch (NotFoundException $e) {
            throw new NotAuthentificatedException("Can't find user.", 0, $e);
        }
    }
    
    public function deleteUser() {
        $this->session->delete('user');
    }
    
}
