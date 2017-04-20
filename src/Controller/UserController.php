<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoList\Model\{
    UserManager,
    User
};
use Kkdshka\TodoListWeb\Http\{
    Response,
    Flash,
    Session
};
use Kkdshka\TodoListWeb\View\Renderer;
use Kkdshka\TodoList\Model\{
    NotFoundException,
    AlreadyExistsException
};
use Kkdshka\TodoListWeb\Authentification\UserStorage;

/**
 * Controller for User
 *
 * @author kkdshka
 */
class UserController extends AbstractController {
    
    /**
     * @var UserManager 
     */
    private $userManager;
    
    /**
     * @var UserStorage
     */
    private $userStorage;
    
    /**
     * @param UserManager $userManager User manager.
     * @param Renderer $renderer Template renderer.
     * @param Flash $flash Flash messages.
     * @param UserStorage $userStorage Holds user.
     */
    public function __construct(UserManager $userManager, Renderer $renderer, Flash $flash, UserStorage $userStorage) {
        parent::__construct($renderer, $flash);
        $this->userManager = $userManager;
        $this->userStorage = $userStorage;
    }
    
    /**
     * Renders form for creating new user.
     * 
     * @return Response
     */
    public function newAction() : Response {
        return $this->render("user/new");
    }
    
    /**
     * Creates new user.
     * @param array $form
     * @return Response
     */
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
        try {
            $this->userManager->register($form['login'], $form['password']);
        }
        catch (AlreadyExistsException $e) {
            $errors[] = "Login already exists!";
            return $this->render("user/new", ['user' => $form, 'errors' => $errors]);
        }
        $this->addFlash('success', 'You successfully registered!');
        return $this->redirect("/");
    }
    
    /**
     * Renders form for logging in.
     * 
     * @return Response
     */
    public function logInAction() : Response {
        return $this->render("user/login");
    }
    
    /**
     * Aunthentificate user.
     * 
     * @param array $form Entered user data.
     * @return Response
     */
    public function authentificateAction(array $form) : Response {
        $errors = [];
        try {
            $user = $this->userManager->find($form['login']);
        }
        catch (NotFoundException $e) {
            $errors[] = "Wrong login or password!";
            return $this->render("user/login", ['errors' => $errors]);
        }
        if (!$this->userManager->checkPassword($user, $form['password'])) {
            $errors[] = "Wrong login or password!";
            return $this->render("user/login", ['errors' => $errors]);
        }
        $this->userStorage->setUser($user);
        $this->addFlash('success', 'You successfully logged in!');
        return $this->redirect("/");
    }
    
    /**
     * Log out user.
     * 
     * @return Response
     */
    public function logOutAction() : Response {
        $this->userStorage->deleteUser();
        return $this->redirect("/");
    }
    
}
