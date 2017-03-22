<?php

declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoList\Model\{
    TaskManager,
    Status,
    Priority,
    Task
};
use Kkdshka\TodoListWeb\Http\Response;
use Kkdshka\TodoListWeb\Http\Flash;
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Description of TaskController
 *
 * @author Ксю
 */
class TaskController extends AbstractController {

    /**
     * @var TaskManager
     */
    private $taskManager;
    private static $priorities = [
        Priority::LOWEST => "Lowest",
        Priority::LOW => "Low",
        Priority::NORMAL => "Normal",
        Priority::HIGH => "High",
        Priority::HIGHEST => "Highest"
    ];
    private static $statuses = [
        Status::STATUS_NEW => "New",
        Status::STATUS_IN_PROGRESS => "In progress",
        Status::STATUS_DELAYED => "Delayed",
        Status::STATUS_COMPLETED => "Completed"
    ];
    
    public function __construct(TaskManager $taskManager, Renderer $renderer, Flash $flash) {
        parent::__construct($renderer, $flash);
        $this->taskManager = $taskManager;
    }

    public function allAction(): Response {
        $tasks = $this->taskManager->getAll();
        return $this->render("task/all", [
            'tasks' => $tasks
        ]);
    }

    public function newAction(): Response {
        return $this->render("task/new", [
            'task' => ['priority' => Priority::NORMAL, 'status' => Status::STATUS_NEW]
        ]);
    }

    public function createAction(array $form): Response {
        $errors = [];
        if (empty($form['subject'])) {
            $errors[] = "Subject can't be empty!";
        }
        if (!empty($errors)) {
            return $this->render("task/new", [
                'errors' => $errors,
                'task' => $form   
            ]);
        }
        
        $task = new Task(
            $form['subject'], 
            $form['description'], 
            (int) $form['priority'], 
            $form['status']
        );
        
        $this->taskManager->create($task);
        
        $this->addFlash('success', 'Task successfully created!');
        
        return $this->redirect("/");
    }

    public function editAction(int $id): Response {
        $task = $this->taskManager->findTaskById($id);
        return $this->render("task/edit", [
            'task' => $task
        ]);
    }

    public function updateAction(int $id, array $form): Response {
        $errors = [];
        if (empty($form['subject'])) {
            $errors[] = "Subject can't be empty!";
        }
        if (!empty($errors)) {
            $form['id'] = $id;
            return $this->render("task/edit", [
                'errors' => $errors,
                'task' => $form   
            ]);
        }
        
        $task = $this->taskManager->findTaskById($id);

        $task->setSubject($form['subject']);
        $task->setDescription((string) $form['description']);
        $task->setPriority((int) $form['priority']);
        $task->setStatus($form['status']);

        $this->taskManager->update($task);
        
        $this->addFlash('success', 'Task successfully edited!');

        return $this->redirect("/");
    }

    public function completeAction(int $id): Response {
        $task = $this->taskManager->findTaskById($id);
        $task->setStatus(Status::STATUS_COMPLETED);
        $this->taskManager->update($task);
        return $this->redirect("/");
    }

    public function deleteAction(int $id): Response {
        $task = $this->taskManager->findTaskById($id);
        $this->taskManager->delete($task);
        
        $this->addFlash('success', 'Task successfully deleted!');
        
        return $this->redirect("/");
    }

    protected function render(string $template, array $vars = array()) : Response {
        $vars['statuses'] = self::$statuses;
        $vars['priorities'] = self::$priorities;
        return parent::render($template, $vars);
    }
}
