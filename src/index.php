<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Kkdshka\TodoListWeb\Controller\{
    TaskController,
    UserController
};
use Kkdshka\TodoListWeb\View\TwigRenderer;
use Kkdshka\TodoList\Model\{
    TaskManager,
    UserManager
};
use \Kkdshka\TodoList\Repository\{
    TaskSqliteRepository,
    UserSqliteRepository
};
use Kkdshka\TodoListWeb\Http\{
    Response,
    Flash,
    Session,
    NotFoundException
};
use Kkdshka\TodoListWeb\Authentification\{
    SessionUserStorage,
    NotAuthentificatedException
};

session_start();
$session = new Session($_SESSION);
try {
    $flash = $session->get('flash');
} catch (NotFoundException $ex) {
    $flash = new Flash();
}

$connectionUrl = "sqlite:C:/Development/Temp/todolist.db";
$renderer = new TwigRenderer(__DIR__ . "/templates");
$userStorage = new SessionUserStorage($session);

$userRepository = new UserSqliteRepository($connectionUrl);
$userManager = new UserManager($userRepository);
$userController = new UserController($userManager, $renderer, $flash, $userStorage);

$taskRepository = new TaskSqliteRepository($connectionUrl);
$taskManager = new TaskManager($taskRepository);
$taskController = new TaskController($taskManager, $renderer, $flash, $userStorage);

if (array_key_exists('action', $_GET)) {
    $action = $_GET['action'];
}
else {
    $action = '';
}
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($action == '' && $method == 'GET') {
        $response = $taskController->allAction();
    }
    elseif ($action == 'create' && $method == 'GET') {
        $response = $taskController->newAction();
    }
    elseif ($action == 'create' && $method == 'POST') {
        $response = $taskController->createAction($_POST);
    }
    elseif ($action == 'edit' && $method == 'GET') {
        $response = $taskController->editAction($_GET['id']);
    }
    elseif ($action == 'edit' && $method == 'POST') {
        $response = $taskController->updateAction($_GET['id'], $_POST);
    }
    elseif ($action == 'complete' && $method == 'GET') {
        $response = $taskController->completeAction($_GET['id']);
    }
    elseif ($action == 'delete' && $method == 'GET') {
        $response = $taskController->deleteAction($_GET['id']);
    }
    elseif ($action == 'register' && $method == 'GET') {
        $response = $userController->newAction();
    }
    elseif ($action == 'register' && $method == 'POST') {
        $response = $userController->createAction($_POST);
    }
    elseif ($action == 'login' && $method == 'GET') {
        $response = $userController->logInAction();
    }
    elseif ($action == 'login' && $method == 'POST') {
        $response = $userController->authentificateAction($_POST);
    }
    elseif ($action == 'logout' && $method == 'GET') {
        $response = $userController->logOutAction();
    }
    else {
        throw new InvalidArgumentException("Unknown action $action.");
    }
}
catch(NotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    exit(0);
}
catch(NotAuthentificatedException $e) {
    $response = new Response();
    $response->setHeader('location', '/?action=login');
}

$session->set('flash', $flash);

foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}
echo $response->getBody();
