<?php

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoListWeb\Http\Response;
use Kkdshka\TodoListWeb\Http\Flash;
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Description of AbstractController
 *
 * @author Ксю
 */
abstract class AbstractController {
    private $renderer;
    private $flash;

    public function __construct(Renderer $renderer, Flash $flash) {
            $this->renderer = $renderer;
            $this->flash = $flash;
    }    
    
    protected function render(string $template, array $vars = []) : Response {
        $vars['flash'] = $this->flash->getMessages(); 
        $response = new Response;
        $body = $this->renderer->render($template, $vars);
        $response->setBody($body);
        return $response;
    }
    
    protected function redirect(string $location) : Response  {
        $response = new Response;
        $response->setHeader('Location', $location);
        return $response;
    } 
    
    protected function addFlash(string $type, string $message) {
        $this->flash->addMessage($type, $message);
    }
}
