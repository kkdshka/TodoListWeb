<?php

namespace Kkdshka\TodoListWeb\Http;

use \PHPUnit\Framework\TestCase;
use Kkdshka\TodoListWeb\Http\Flash;

class FlashTest extends TestCase {
    
    /**
     * @test
     * @covers Kkdshka\TodoListWeb\Http\Flash::addMessage
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Unknown type unexisted given.
     */
    public function shouldNotAddMessageWithWrongType() {
        $flash = new Flash();
        $flash->addMessage('unexisted', 'Unexisted!');
    }
    
    /**
     * @test
     */
    public function shouldAddMessage() {
        $flash = new Flash();
        $flash->addMessage(Flash::SUCCESS, 'Success!');
        
        $this->assertEquals([Flash::SUCCESS => 'Success!'], $flash->getMessages());
    }
    
    /**
     * @test
     */
    public function shouldClearMessagesAfterGettingThem() {
        $flash = new Flash();
        $flash->addMessage(Flash::SUCCESS, 'Success!');
        $flash->getMessages();
        
        $this->assertEquals([], $flash->getMessages());
    }
}
