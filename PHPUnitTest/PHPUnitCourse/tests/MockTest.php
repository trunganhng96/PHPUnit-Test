<?php
use PHPUnit\Framework\TestCase;

    class MockTest extends TestCase {
        public function testMock() {
            // $mailer = new Mailer;
            $mock = $this->createMock(Mailer::class);
            $mock->method('sendMessage')->willReturn(true);
            $result = $mock->sendMessage('trunganh.ng96@gmail.com', 'Hello');
            $this->assertTrue($result);
        }
    }
?>