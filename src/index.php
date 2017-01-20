<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Kkdshka\TodoListWeb\Controller\TaskController;
use Kkdshka\TodoListWeb\View\PlainPhpRenderer;
use Kkdshka\TodoList\Model\TaskManager;
use Kkdshka\TodoList\Repository\RepositoryFactory;
//use InvalidArgumentException;

$connectionUrl = "csv:C:/Development/Temp/todolist.csv";
$repository = (new RepositoryFactory)->create($connectionUrl);
$taskManager = new TaskManager($repository);
$renderer = new PlainPhpRenderer(__DIR__ . "/templates");
$taskController = new TaskController($taskManager, $renderer);

if (array_key_exists('action', $_GET)) {
    $action = $_GET['action'];
}
else {
    $action = '';
}
$method = $_SERVER['REQUEST_METHOD'];

if ($action == '' && $method == 'GET') {
    echo $taskController->allAction();
}
elseif ($action == 'create' && $method == 'GET') {
    echo $taskController->newAction();
}
elseif ($action == 'create' && $method == 'POST') {
    echo $taskController->createAction($_POST);
}
elseif ($action == 'complete' && $method == 'GET') {
    echo $taskController->completeAction($_GET['id']);
}
elseif ($action == 'delete' && $method == 'GET') {
    echo $taskController->deleteAction($_GET['id']);
}
else {
    throw new InvalidArgumentException("Unknown action $action.");
}