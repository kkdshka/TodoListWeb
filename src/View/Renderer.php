<?php

namespace Kkdshka\TodoListWeb\View;

/**
 *
 * @author Ксю
 */
interface Renderer {
    function render(string $templateName, array $templateVars) : string;
}
