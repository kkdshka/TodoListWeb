<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Authentification;

use Kkdshka\TodoList\Model\User;

/**
 * Holds User.
 * 
 * @author kkdshka
 */
interface UserStorage {

    /**
     * Saves user in storage.
     * 
     * @param User $user User to save.
     */
    public function setUser(User $user);
    
    /**
     * Returns user from storage.
     */
    public function getUser() : User;
    
}
