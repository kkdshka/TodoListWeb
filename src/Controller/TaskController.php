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

    public function __construct(TaskManager $taskManager, Renderer $renderer) {
        parent::__construct($renderer);
        $this->taskManager = $taskManager;
    }

    public function allAction(): Response {
        $tasks = $this->taskManager->getAll();
        return $this->render("task/all", [
            'priorities' => self::$priorities,
            'statuses' => self::$statuses,
            'tasks' => $tasks
        ]);
    }

    public function newAction(): Response {
        return $this->render("task/new", [
            'priorities' => self::$priorities,
            'statuses' => self::$statuses
        ]);
    }

    public function createAction(array $form): Response {
        $task = new Task(
            $form['subject'], 
            $form['description'], 
            (int) $form['priority'], 
            $form['status']
        );
        $this->taskManager->create($task);
        return $this->redirect("/");
    }

    public function editAction(int $id): Response {
        $task = $this->taskManager->findTaskById($id);
        return $this->render("task/edit", [
            'priorities' => self::$priorities,
            'statuses' => self::$statuses,
            'task' => $task
        ]);
    }

    public function updateAction(int $id, array $form): Response {
        $task = $this->taskManager->findTaskById($id);

        $task->setSubject($form['subject']);
        $task->setDescription((string) $form['description']);
        $task->setPriority((int) $form['priority']);
        $task->setStatus($form['status']);

        $this->taskManager->update($task);

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
        return $this->redirect("/");
    }

}
