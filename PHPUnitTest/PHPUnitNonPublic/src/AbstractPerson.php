<?php
    abstract class AbstractPerson {
        protected $surname;
        public function __construct(string $surname) {
            $this->surname = $surname;
        }

        abstract protected function getTitle();
        public function getNameAndTitle() {
            return $this->getTitle() . ' ' . $this->surname;
        }
    }
?>