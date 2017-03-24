<?php
declare (strict_types = 1);

namespace Kkdshka\TodoListWeb\View;

use \PHPUnit\Framework\TestCase;

/**
 * @author kkdshka
 */
class PlainPhpRendererTest extends TestCase {
    
    /**
     * @test
     */
    public function shouldRender() {
        $templateRootPath = __DIR__ . "\..\data";
        $renderer = new PlainPhpRenderer($templateRootPath);
        $actual = $renderer->render('template', ['var_name' => 'test']);
        $expected = '<html>test</html>';
        $this->assertEquals($expected, $actual);
    }
    
}
