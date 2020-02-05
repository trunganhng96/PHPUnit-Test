<?php
    class User {
        public $first_name;
        public $surname;
        public $email;
        protected $mailer;

        public function setMailer(Mailer $mailer) {
            $this->mailer = $mailer;
        }

        public function getFullName() {
            return trim("$this->first_name $this->surname");
        }

        public function notify($message) {
            // $mailer = new Mailer;
            return $this->mailer->sendMessage($this->email, $message);
        }
    }
?>