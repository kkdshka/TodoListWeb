<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoList\Model\{
    TaskManager,
    Status,
    Priority,
    Task
};
use Kkdshka\TodoListWeb\Http\ {
    Response,
    Flash,
    Session
};
use Kkdshka\TodoListWeb\View\Renderer;
use Kkdshka\TodoListWeb\Authentification\{
    NotAuthentificatedException,
    UserStorage
};

/**
 * Controller for task.
 *
 * @author kkdshka
 */
class TaskController extends AbstractController {

    /**
     * @var TaskManager
     */
    private $taskManager;
    
    /**
     * @var UserStorage 
     */
    private $userStorage;
    
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
    
    /**
     * @param TaskManager $taskManager Task manager.
     * @param Renderer $renderer Template renderer.
     * @param Flash $flash Flash messages.
     * @param UserStorage $userStorage Holds user.
     */
    public function __construct(TaskManager $taskManager, Renderer $renderer, Flash $flash, UserStorage $userStorage) {
        parent::__construct($renderer, $flash);
        $this->taskManager = $taskManager;
        $this->userStorage = $userStorage;
    }

    /**
     * Renders all user's tasks.
     * 
     * @return Response
     */
    public function allAction(): Response {
        $user = $this->userStorage->getUser();
        $tasks = $this->taskManager->getUserTasks($user);
        
        return $this->render("task/all", [
            'tasks' => $tasks
        ]);
    }

    /**
     * Renders form for new task.
     * 
     * @return Response
     */
    public function newAction(): Response {
        return $this->render("task/new", [
            'task' => ['priority' => Priority::NORMAL, 'status' => Status::STATUS_NEW]
        ]);
    }

    /**
     * Creates task. 
     * 
     * @param array $form Data for new task.
     * @return Response
     */
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
        $user = $this->userStorage->getUser();
        $task = new Task(
            $user,
            $form['subject'], 
            $form['description'], 
            (int) $form['priority'], 
            $form['status']
        );
        
        $this->taskManager->create($task);
        
        $this->addFlash('success', 'Task successfully created!');
        
        return $this->redirect("/");
    }

    
    /**
     * Renders form for editing task by id.
     * 
     * @param int $id Task id.
     * @return Response
     */
    public function editAction(int $id): Response {
        $task = $this->findTask($id);
        return $this->render("task/edit", [
            'task' => $task
        ]);
    }

    /**
     * Update task by id.
     * 
     * @param int $id Task id.
     * @param array $form Data for editing task.
     * @return Response
     */
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
        
        $task = $this->findTask($id);
        $task->setSubject($form['subject']);
        $task->setDescription((string) $form['description']);
        $task->setPriority((int) $form['priority']);
        $task->setStatus($form['status']);

        $this->taskManager->update($task);
        
        $this->addFlash('success', 'Task successfully edited!');

        return $this->redirect("/");
    }

    /**
     * Completes task by id.
     * 
     * @param int $id Task id.
     * @return Response
     */
    public function completeAction(int $id): Response {
        $task = $this->findTask($id);
        $task->setStatus(Status::STATUS_COMPLETED);
        $this->taskManager->update($task);
        
        return $this->redirect("/");
    }

    /**
     * Deletes task by id.
     * 
     * @param int $id Task id.
     * @return Response
     */
    public function deleteAction(int $id): Response {
        $task = $this->findTask($id);
        $this->taskManager->delete($task);
        
        $this->addFlash('success', 'Task successfully deleted!');
        
        return $this->redirect("/");
    }

    /**
     * Finds user's task by id.
     * 
     * @param int $id Task id.
     * @return Task
     */
    private function findTask(int $id) : Task {
        $user = $this->userStorage->getUser();
        return $this->taskManager->find($id, $user);
    }
    
    /**
     * Adds common variables to $vars[].
     * 
     * @return Response
     */
    protected function render(string $template, array $vars = array()) : Response {
        $vars['loggedUser'] = $this->userStorage->getUser();
        $vars['statuses'] = self::$statuses;
        $vars['priorities'] = self::$priorities;
        return parent::render($template, $vars);
    }
    
}
