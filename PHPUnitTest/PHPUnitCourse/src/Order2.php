<?php
    class Order {
        public $amount = 0;
        protected $gateway;

        public function __construct(int $quantity, float $unit_price) {
            $this->quantity = $quantity;
            $this->unit_price = $unit_price;
            $this->amount = $quantity * $unit_price;
        }

        public function process(PaymentGateway $gateway) {
            $gateway->charge($this->amount);
        }
    }
?>