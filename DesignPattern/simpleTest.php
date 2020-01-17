<?php
    interface Shape {
        function draw();
    }

    class Circle implements Shape {
        public function draw() {
            echo "Draw circle";
        }
    }

    abstract class AbstractFactory {
        abstract function getShape($shape);
    }

    class ShapeFactory extends AbstractFactory {
        public function getShape($shape) {
            switch ( $shape ) {
                case 'Shape':
                    return new Circle();
                    break;
            }
        }
    }

    class FactoryProducer {
        public static function getFactory($choice) {
            $choice = strtolower($choice);
            if($choice == 'shape') {
                return new ShapeFactory();
            }
            return null;
        }
    }

    $shapeFactory = FactoryProducer::getFactory('shape');
    $shape = $shapeFactory->getShape('Shape');
    $shape->draw();
?>