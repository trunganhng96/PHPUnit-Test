<!-- CẤU TRÚC
-AbstractFactory: định nghĩa một giao tiếp cho thao tác khởi tạo các "sản phẩm" ảo (AbstractProduct)
-ConcreteFactory: thực thi giao tiếp AbstractFactory để tạo ra đối tượng cụ thể
-AbstractProduct: định nghĩa một lớp ảo cho một loại đối tương "sản phẩm"
-Product: kế thừa từ từ lớp "sản phẩm" ảo AbstractProduct, các lớp Product định nghĩa từ đối tượng cụ thể
-Client: sử dụng các lớp AbstractFactory và AbstractProduct trong hệ thống -->

<?php
    // Bước 1: Tạo interface Shape được hiểu là 1 AbstractProduct
    interface Shape {
        // Có thể định nghĩa sẵn const hoặc không
        const SQUARE = 1;
        const CIRCLE = 2;
        const RECTANGLE = 3;
        // general method
        function draw();
    }

    // Bước 2: Tạo các class cụ thể implements cùng 1 interface Shape, đây chính là các Product đã được nhắc đến ở trên.
    class Circle implements Shape {
        public function draw() {
            // thực hiện code vẽ hình tròn tại đây
            echo "Draw circle";
        }
    }
    class Square implements Shape {
        public function draw() {
            // thực hiện code vẽ hình vuông tại đây
            echo "Draw square";
        }
    }
    class Rectangle implements Shape {
        public function draw() {
            // thực hiện code vẽ hình chữ nhật tại đây
            echo "Draw rectangle";
        }
    }

    // Bước 3: Tạo interface Color được hiểu là 1 AbstractProduct tương tự Shape
    interface Color {
        // general method
        function fill();
    }

    // Bước 4: Tương tự bước 2, tạo các class và implements cùng 1 interface Color, dĩ nhiên cũng là dạng sản phẩm - Product, của nhà máy - Factory
    class Red implements Color {
        public function fill() {
            echo "Filled red";
        }
    }
    class Green implements Color {
        public function fill() {
            echo "Filled green";
        }
    }
    class Blue implements Color {
        public function fill() {
            echo "Filled blue";
        }
    }

    // Bước 5: Tạo ra 1 lớp Abstract với phương thức giáo tiếp đến thao tác khởi tạo các Shape và Color object - đây chính là khái niệm AbstractFactory được định nghĩa ở trên.
    abstract class AbstractFactoryShape {
        abstract function getShape($shape);
    }
    abstract class AbstractFactoryColor {
        abstract function getColor($color);
    }

    // Bước 6: Tạo lớp Factory kế thừa AbstractFactory để thực hiện generate ra các object cụ thể dựa trên các thông tin được đưa ra. Các lớp này còn được gọi là ConcreteFactory.
    class ShapeFactory extends AbstractFactoryShape {
        public function getShape($shape) {
            switch ( $shape ) {
                case 'Shape::SQUARE':
                    return new Square();
                    break;
                case 'Shape::CIRCLE':
                    return new Circle();
                    break;
                case 'Shape::RECTANGLE':
                    return new Rectangle();
                    break;
                default:
                    return null;
                    break;
            }
            return null;
        }
    }
    class ColorFactory extends AbstractFactoryColor {
        public function getColor($color) {
            switch ( $color ) {
                case 'red':
                    return new Red();
                    break;
                case 'blue':
                    return new Blue();
                    break;
                case 'green':
                    return new Green();
                    break;
                default:
                    return null;
                    break;
            }
            return null;
        }
    }

    // Bước 7: Tạo FactoryProducer để khởi tạo 1 abstract Shape/Color Factory
    class FactoryProducer {
        public static function getFactory($choice) {
            $choice = strtolower($choice);
            if($choice == 'shape') {
                return new ShapeFactory();
            } else if($choice == 'color') {
                return new ColorFactory();
            }
            return null;
        }
    }

    // Bước 8: Như vậy là đã gần đầy đủ 1 mô hình AbstractFactory, chúng ta chỉ cần phần Client để sử dụng AbstractFactory và AbstractProduct trong hệ thống/apps của mình
    $shapeFactory = FactoryProducer::getFactory('shape');
    // khởi tạo lớp ShapeFactory (tạo ra "nhà máy")
    $shape = $shapeFactory->getShape('Shape::CIRCLE');
    // lấy object Shape với kiểu hình là Circle (lấy "sản phẩm")
    $shape->draw();
    //gọi method draw từ Shape Circle (sử dụng)

    $colorFactory = FactoryProducer::getFactory('color');
    $color = $colorFactory->getColor('red');
    $color->fill();
    //Tương tự với Color

    // Output: Draw Circle
    // Output: Filled red
?>