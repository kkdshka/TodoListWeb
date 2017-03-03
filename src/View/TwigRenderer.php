<?php

namespace Kkdshka\TodoListWeb\View;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Description of PlainPhpRenderer
 *
 * @author Ксю
 */
class TwigRenderer implements Renderer {
    private $twig;
    
    public function __construct(string $templateRootDir) {
        $loader = new Twig_Loader_Filesystem($templateRootDir);
        $this->twig = new Twig_Environment($loader);
    }
    
    public function render(string $templateName, array $templateVars) : string {
        $template = $templateName . ".twig";
        return $this->twig->render($template, $templateVars);
    }
}