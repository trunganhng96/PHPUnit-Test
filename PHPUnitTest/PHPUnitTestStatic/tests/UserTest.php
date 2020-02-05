<?php
    use PHPUnit\Framework\TestCase;

    class UserTest extends TestCase {
        // public function testNotifyReturnsTrue() {
        //     $user = new User('dave@example.com');
        //     $mailer = $this->createMock(Mailer::class);
        //     $mailer->expects( $this->once() )->method('send')->willReturn(true);
        //     $user->setMailer($mailer);
        //     $this->assertTrue($user->notify('Hello!'));
        // }

        // public function testNotifyReturnsTrue() {
        //     $user = new User('dave@example.com');
        //     // $user->setMailerCallable( [Mailer::class, 'send'] );
        //     $user->setMailerCallable( function() {
        //         echo "mocked";
        //         return true;
        //     } );
        //     $this->assertTrue($user->notify('Hello!'));
        // }

        public function tearDown() : void {
            Mockery::close();
        }

        public function testNotifyReturnsTrue() {
            $user = new User('dave@example.com');
            $mock = Mockery::mock('alias:Mailer');
            $mock->shouldReceive('send')->once()->with($user->email, 'Hello!')->andReturn(true);
            $this->assertTrue($user->notify('Hello!'));
        }
    }
?>