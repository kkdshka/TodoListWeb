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
use Kkdshka\TodoListWeb\Http\Response;
use Kkdshka\TodoListWeb\Http\Flash;

session_start();
if (array_key_exists('flash', $_SESSION)) {
    $flash = unserialize($_SESSION['flash']);
}
 else {
    $flash = new Flash();
}

$connectionUrl = "sqlite:C:/Development/Temp/todolist.db";
$taskRepository = new TaskSqliteRepository($connectionUrl);
$taskManager = new TaskManager($taskRepository);
$renderer = new TwigRenderer(__DIR__ . "/templates");
$taskController = new TaskController($taskManager, $renderer, $flash);
$userRepository = new UserSqliteRepository($connectionUrl);
$userManager = new UserManager($userRepository);
$userController = new UserController($userManager, $renderer, $flash);

if (array_key_exists('action', $_GET)) {
    $action = $_GET['action'];
}
else {
    $action = '';
}
$method = $_SERVER['REQUEST_METHOD'];

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
else {
    throw new InvalidArgumentException("Unknown action $action.");
}

$_SESSION['flash'] = serialize($flash);

foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}
echo $response->getBody();
