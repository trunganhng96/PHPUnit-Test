<?php
    use PHPUnit\Framework\TestCase;

    class ItemTest extends TestCase {
        // public function testDescriptionIsNotEmpty() {
        //     $item = new Item;
        //     $this->assertNotEmpty( $item->getDescription() );
        // }

        // public function testIDisAnInteger() {
        //     $item = new ItemChild;
        //     $this->assertIsInt( $item->getID() );
        // }

        //Error because getToken() is method private
        // public function testIDisAString() {
        //     $item = new ItemChild;
        //     $this->assertIsString( $item->getToken() );
        // }
        
        //Voi function nay ta co the test method co thuoc tinh private
        public function testTokenisAString() {
            $item = new Item;
            $reflector = new ReflectionClass(Item::Class);
            $method = $reflector->getMethod('getToken');
            $nethod->serAccessible(true);
            $result = $method->invoke($item);
            $this->assertIsString($result);
        }

        public function testPreFixedTokenStartsWithPrefix() {
            $item = new Item;
            $reflector = new ReflectionClass(Item::Class);
            $method = $reflector->getMethod('getToken');
            $nethod->serAccessible(true);
            $result = $method->invokeArgs($item, ['example']);
            $this->assertStringStartWith('example', $result);
        }
    }
?>