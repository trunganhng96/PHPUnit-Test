<?php
    class Item {
        // public function getDescription() {
        //     return $this->getID() . $this->getToken();
        // }

        // protected function getID() {
        //     return rand();
        // }

        private function getToken() {
            return uniqid();
        }

        private function getPrefixedToken(string $prefix) {
            return uniqid($prefix);
        }
    }
?>