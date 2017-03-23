<?php

namespace Kkdshka\TodoListWeb\View;

/**
 * Renders template.
 * 
 * @author Ксю
 */
interface Renderer {
    /**
     * Renders template with given variables.
     * 
     * @param string $templateName Template to render.
     * @param array $templateVars Variables for template (e.g. 'name' => 'value').
     */
    function render(string $templateName, array $templateVars) : string;
}
