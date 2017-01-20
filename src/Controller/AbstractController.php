<?php

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoListWeb\Http\Response;
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Description of AbstractController
 *
 * @author Ксю
 */
abstract class AbstractController {
    private $renderer;

    public function __construct(Renderer $renderer) {
            $this->renderer = $renderer;
    }    
    
    protected function render(string $template, array $vars = []) : Response {
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
}
