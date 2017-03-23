<?php

namespace Kkdshka\TodoListWeb\Controller;

use Kkdshka\TodoListWeb\Http\Response;
use Kkdshka\TodoListWeb\Http\Flash;
use Kkdshka\TodoListWeb\View\Renderer;

/**
 * Contains helpers for other controllers.
 *
 * @author Ксю
 */
abstract class AbstractController {
    /**
     * @var Renderer 
     */
    private $renderer;
    /**
     * @var Flash
     */
    private $flash;

    /**
     * @param Renderer $renderer Renderer for templates.
     * @param Flash $flash Flash messages container.
     */
    public function __construct(Renderer $renderer, Flash $flash) {
            $this->renderer = $renderer;
            $this->flash = $flash;
    }    
    
    /**
     * Renders template with given variables.
     * 
     * @param string $template Name of template to render.
     * @param array $vars Variables for template (e.g. 'name' => 'value').
     * @return Response 
     */
    protected function render(string $template, array $vars = []) : Response {
        $vars['flash'] = $this->flash->getMessages(); 
        $response = new Response;
        $body = $this->renderer->render($template, $vars);
        $response->setBody($body);
        return $response;
    }
    
    /**
     * Redirects to another location.
     * 
     * @param string $location Location to redirect.
     * @return Response
     */
    protected function redirect(string $location) : Response  {
        $response = new Response;
        $response->setHeader('Location', $location);
        return $response;
    } 
    
    /**
     * Adds flash message with given type.
     * 
     * @param string $type Type of message (e.g. success) 
     * @param string $message Flash message.
     */
    protected function addFlash(string $type, string $message) {
        $this->flash->addMessage($type, $message);
    }
}
