<?php

declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoList\Model\TaskManager;
use Kkdshka\TodoListWeb\Http\Response;
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Description of TaskController
 *
 * @author Ксю
 */
class TaskController extends AbstractController {
    private $taskManager;
    
    public function __construct(TaskManager $taskManager, Renderer $renderer) {
        parent::__construct($renderer);
        $this->taskManager = $taskManager;
    }
    
    public function allAction() : Response {
        $tasks = $this->taskManager->getAll();
        return $this->render("task/all", ['tasks' => $tasks]);
    }
    
    public function newAction() : Response {
        return $this->render("task/new");
    }
    
    public function createAction(array $form) : Response {
        $subject = $form['subject'];
        $this->taskManager->create($subject);
        return $this->redirect("/");
    }
    
    public function completeAction(int $id) : Response {
        $task = $this->taskManager->findTaskById($id);
        $this->taskManager->complete($task);
        return $this->redirect("/");
    }
    
    public function deleteAction(int $id) : Response {
        $task = $this->taskManager->findTaskById($id);
        $this->taskManager->delete($task);
        return $this->redirect("/");
    }
}
