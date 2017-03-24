<?php

namespace Kkdshka\TodoListWeb\View;

use InvalidArgumentException;

/**
 * Renders PHP template.
 *
 * @author kkdshka
 */
class PlainPhpRenderer implements Renderer {
    /**
     * @var string 
     */
    private $templateRootDir;
    
    /**
     * @param string $templateRootDir Path to directory with templates.
     */
    public function __construct(string $templateRootDir) {
        $this->templateRootDir = rtrim($templateRootDir, DIRECTORY_SEPARATOR);
    }

    /**
     * {@inheritDoc}
     */
    public function render(string $templateName, array $templateVars = []) : string {
        $templatePath = "{$this->templateRootDir}" . DIRECTORY_SEPARATOR . "{$templateName}.php";
        if (!file_exists($templatePath)) {
            throw new InvalidArgumentException("File $templatePath not found.");
        }
        extract($templateVars);
        ob_start();
        require_once $templatePath;
        $html = ob_get_clean();
        return $html;
    }
}
