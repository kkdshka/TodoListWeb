<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Kkdshka\TodoListWeb\Controller\TaskController;
use Kkdshka\TodoListWeb\View\TwigRenderer;
use Kkdshka\TodoList\Model\TaskManager;
use Kkdshka\TodoList\Repository\RepositoryFactory;
use Kkdshka\TodoListWeb\Http\Response;

$connectionUrl = "csv:C:/Development/Temp/todolist.csv";
$repository = (new RepositoryFactory)->create($connectionUrl);
$taskManager = new TaskManager($repository);
$renderer = new TwigRenderer(__DIR__ . "/templates");
$taskController = new TaskController($taskManager, $renderer);

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
else {
    throw new InvalidArgumentException("Unknown action $action.");
}

foreach ($response->getHeaders() as $name => $value) {
    header("$name: $value");
}
echo $response->getBody();
