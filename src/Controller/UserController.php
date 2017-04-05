<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoList\Model\{
    UserManager,
    User
};
use Kkdshka\TodoListWeb\Http\{
    Response,
    Flash
};
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Controller for User
 *
 * @author kkdshka
 */
class UserController extends AbstractController {
    
    private $userManager;
    
    public function __construct(UserManager $userManager, Renderer $renderer, Flash $flash) {
        parent::__construct($renderer, $flash);
        $this->userManager = $userManager;
    }
    
    public function newAction() : Response {
        return $this->render("user/new", []);
    }
    
    public function createAction(array $form) : Response {
        $errors = [];
        if (empty($form['login'])) {
            $errors[] = "Login can't be empty!";
        }
        if (empty($form['password'])) {
            $errors[] = "Password can't be empty!";
        }
        elseif ($form['password'] !== $form['repeatPassword']) {
            $errors[] = "You entered different passwords!";
        }
        if (!empty($errors)) {
            return $this->render("user/new", ['user' => $form, 'errors' => $errors]);
        }
        $this->userManager->register($form['login'], $form['password']);
        $this->addFlash('success', 'You successfully registered!');
        return $this->redirect("/");
    }
    
}
