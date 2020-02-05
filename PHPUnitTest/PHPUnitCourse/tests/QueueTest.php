<?php
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase {
    protected $queue;
    protected function setUp(): void {
        $this->queue = new Queue;
    }

    // protected function tearDown(): void {
    //     unset($this->queue);
    // }

    // public static function setUpBeforeClass(): void {
    //     $this->queue = new Queue;
    // }

    // public static function tearDownAfterClass(): void {
    //     $this->queue = null;
    // }

    public function testNewQueueIsEmpty() {
        // $queue = new Queue;
        $this->assertEquals(0, $this->queue->getCount());
        // return $queue;
    }

    // /** 
    //  *  @depends testNewQueueIsEmpty
    //  */
    public function testAnItemIsAddedToTheQueue() {
        // $queue = new Queue;
        $this->queue->push('green');
        $this->assertEquals(1, $this->queue->getCount());
        // return $queue;
    }

    // /** 
    //  *  @depends testAnItemIsAddedToTheQueue
    //  */
    public function testAnItemIsRemovedFromTheQueue() {
        // $queue = new Queue;
        $this->queue->push('green');
        $item = $this->queue->pop();
        $this->assertEquals(0, $this->queue->getCount());
        $this->assertEquals('green', $item);
    }

    public function testAnItemIsRemovedFromTheFrontOfTheQueue() {
        $this->queue->push('first');
        $this->queue->push('second');
        $this->assertEquals('first', $this->queue->pop());
    }

    public function testMaxNumberOfItemCanBeAdded() {
        for ($i = 0; $i < Queue::MAX_ITEMS; $i++) {
            $this->queue->push($i);
        }
        $this->assertEquals(Queue::MAX_ITEMS, $this->queue->getCount());
    }

    public function testExceptionThrownWhenAddingAnItemToAFullQueue() {
        for ($i = 0; $i < Queue::MAX_ITEMS; $i++) {
            $this->queue->push($i);
        }
        $this->expectException(QueueException::class);
        $this->expectExceptionMessage("Queue is full");
        $this->queue->push("water thin mint");
    }
}
?>