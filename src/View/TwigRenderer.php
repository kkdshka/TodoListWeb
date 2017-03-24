<?php

namespace Kkdshka\TodoListWeb\View;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Renders Twig template.
 *
 * @author kkdshka
 */
class TwigRenderer implements Renderer {
    /**
     * Template renderer.
     * 
     * @var Twig_Environment 
     */
    private $twig;
    
    /**
     * @param string $templateRootDir Path to directory with templates.
     */
    public function __construct(string $templateRootDir) {
        $loader = new Twig_Loader_Filesystem($templateRootDir);
        $this->twig = new Twig_Environment($loader);
    }
    
    /**
     * {@inheritDoc}
     */
    public function render(string $templateName, array $templateVars) : string {
        $template = $templateName . ".twig";
        return $this->twig->render($template, $templateVars);
    }
}