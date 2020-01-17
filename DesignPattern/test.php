<?php
    interface Door {
        public function getDescription();
    }
    
    class WoodenDoor implements Door {
        public function getDescription() {
            echo 'I am a wooden door';
        }
    }
    class IronDoor implements Door {
        public function getDescription() {
            echo 'I am an iron door';
        }
    }

    interface DoorFactory {
        public function makeDoor(): Door;
    }

    // Wooden factory to return carpenter and wooden door
    class WoodenDoorFactory implements DoorFactory {
        public function makeDoor(): Door {
            return new WoodenDoor();
        }
    }
    // Iron door factory to get iron door and the relevant fitting expert
    class IronDoorFactory implements DoorFactory {
        public function makeDoor(): Door {
            return new IronDoor();
        }
    }

    $woodenFactory = new WoodenDoorFactory();
    $door = $woodenFactory->makeDoor();
    $door->getDescription();  
    // Output: I am a wooden door

    $ironFactory = new IronDoorFactory();
    $door = $ironFactory->makeDoor();
    $door->getDescription();  
    // Output: I am an iron door

?>