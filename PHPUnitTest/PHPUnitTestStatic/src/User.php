(<?php
    class User {
        public $email;
        // protected $mailer;
        protected $mailer_callable;
        public function __construct(string $email) {
            $this->email = $email;
        }

        // public function setMailer(Mailer $mailer) {
        //     $this->mailer = $mailer;
        // }

        public function setMailerCallable(callable $mailer_callable) {
            $this->mailer_callable = $mailer_callable;
        }

        public function notify(string $message) {
            // return call_user_func( [Mailer::class, 'send'], $this->email, $message );
            return call_user_func( $this->mailer_callable, $this->email, $message );
        }
    }
?>