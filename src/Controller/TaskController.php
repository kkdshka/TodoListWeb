<?php

declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoList\Model\TaskManager;
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Description of TaskController
 *
 * @author Ксю
 */
class TaskController {
    private $taskManager;
    private $renderer;
    
    public function __construct(TaskManager $taskManager, Renderer $renderer) {
        $this->taskManager = $taskManager;
        $this->renderer = $renderer;
    }
    
    public function allAction() : string {
        $tasks = $this->taskManager->getAll();
        return $this->renderer->render("task/all", ['tasks' => $tasks]);
    }
    
    public function newAction() : string {
        return $this->renderer->render("task/new");
    }
    
    public function createAction(array $form) : string {
        $subject = $form['subject'];
        $this->taskManager->create($subject);
        return $this->allAction();
    }
    
    public function completeAction(int $id) : string {
        $task = $this->taskManager->findTaskById($id);
        $this->taskManager->complete($task);
        return $this->allAction();
    }
    
    public function deleteAction(int $id) : string {
        $task = $this->taskManager->findTaskById($id);
        $this->taskManager->delete($task);
        return  $this->allAction();
    }
}
