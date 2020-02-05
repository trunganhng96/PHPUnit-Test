<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    public function testReturnsFullName() {
        $user = new User;
        $user->first_name = "TrungAnh";
        $user->surname = "Nguyen";
        $this->assertEquals('TrungAnh Nguyen', $user->getFullName());
    }

    public function testFullNameIsEmptyByDefault() {
        $user = new User;
        $this->assertEquals('', $user->getFullName());
    }

    // /**
    //  * @test
    //  */ 
    // public function user_has_first_name() {
    //     $user = new User;
    //     $user->first_name = "TrungAnh";
    //     $this->assertEquals('TrungAnh', $user->first_name);
    // }

    public function testNotificationIsSent() {
        $user = new User;
        $mock_mailer = $this->createMock(Mailer::class);
        $mock_mailer->expects( $this->once() )->method('sendMessage')->with( $this->equalTo('trunganh.ng96@gmail.com'), $this->equalTo('Hello') )->willReturn(true);
        $user->setMailer($mock_mailer);
        $user->email = 'trunganh.ng96@gmail.com';
        $this->assertTrue( $user->notify("Hello") );
    }

    public function testCannotNotifyUserWithNoEmail() {
        $user = new User;
        // $mock_mailer = $this->createMock(Mailer::class);
        // $mock_mailer->method('sendMessage')->will( $this->throwException(new Exception) );
        $mock_mailer = $this->getMockBuilder(Mailer::class)->setMethods(null)->getMock();
        $user->setMailer($mock_mailer);
        $this->expectException(Exception::class);
        $user->notify("Hello");
    }
}
?>