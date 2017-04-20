<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Authentification;

use RuntimeException;

/**
 * In case no user logged in.
 *
 * @author Ксю
 */
class NotAuthentificatedException extends RuntimeException {
}
