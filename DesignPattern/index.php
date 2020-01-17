1 - CREATIONAL DESIGN PATTERNS

<!-- Simple Factory
Tác dụng: Simple factory chỉ đơn giản là tạo ra những phiên bản cho client mà không cần lộ ra bất kì một logic về việc khởi tạo nào tới phía người dùng.

Đ/n: Trong lập trình hướng đối tượng (OOP), một factory là một object được dùng để tạo ra các object khác - thường thì factory là một function hoặc method trả về những object nguyên bản hoặc class từ những method được gọi, được giải định như là "new".

Sử dụng khi nào?: Khi tạo một object thì nó không đơn giản chỉ là đưa ra mà còn liên quan tới một vài vấn đề logic, hãy ghi nhớ việc đặt nó vào trong một factory chuyên dụng thay vì lặp lại đoạn code tương tự ở mọi nơi. -->
<?php    
    interface Door {
        public function getWidth(): float;
        public function getHeight(): float;
    }

    class WoodenDoor implements Door {
        protected $width;
        protected $height;

        public function __construct(float $width, float $height) {
            $this->width = $width;
            $this->height = $height;
        }

        public function getWidth(): float {
            return $this->width;
        }

        public function getHeight(): float {
            return $this->height;
        }
    }

    class DoorFactory {
        public static function makeDoor($width, $height): Door {
            return new WoodenDoor($width, $height);
        }
    }

    // tạo một cái cửa có kích thước 100x200
    $door = DoorFactory::makeDoor(100, 200);

    echo 'Width: ' . $door->getWidth();
    echo 'Height: ' . $door->getHeight();
?>



<!-- Factory Method
Tác dụng: Nó cung cấp một cách để ủy thác các logic về khởi tạo cho những class con.

Đ/n: Trong class - cơ sở của lập trình, factory method pattern là một creational pattern mà sử dụng các method factory để giải quyết vấn đề về khởi tạo các object mà không cần xác định chính xác class của object mà sẽ được tạo ra. Điều này được thực hiện bằng cách tạo ra những object thông qua việc gọi một method factory - hoặc được chỉ định trong interface và implement bởi các class con, hoặc được implement trong class base và ghi đè tùy ý bởi các class dẫn xuất - thay vì được gọi thông qua hàm khởi tạo.

Sử dụng khi nào?: Nó hữu dụng khi có một số việc được sử lý chung trong một class nhưng các class con được yêu cầu có thể được đưa ra bởi các quyết định linh động trong khi chạy. Hay nói cách khác, khi client không biết chính xác class con nào là cần thiết. -->
<?php
    interface Interviewer {
        public function askQuestions();
    }
    
    class Developer implements Interviewer {
        public function askQuestions() {
            echo 'Asking about design patterns!';
        }
    }
    class CommunityExecutive implements Interviewer {
        public function askQuestions() {
            echo 'Asking about community building';
        }
    }

    abstract class HiringManager {
        // Factory method
        abstract protected function makeInterviewer(): Interviewer;
        public function takeInterview() {
            $interviewer = $this->makeInterviewer();
            $interviewer->askQuestions();
        }
    }

    class DevelopmentManager extends HiringManager {
        protected function makeInterviewer(): Interviewer {
            return new Developer();
        }
    }
    class MarketingManager extends HiringManager {
        protected function makeInterviewer(): Interviewer {
            return new CommunityExecutive();
        }
    }

    $devManager = new DevelopmentManager();
    $devManager->takeInterview(); 
    // Output: Asking about design patterns

    $marketingManager = new MarketingManager();
    $marketingManager->takeInterview(); 
    // Output: Asking about community building.
?>



<!-- Abstract Factory
Tác dụng: một factory của các factory; một factory nhóm những cá thể nhưng các factory liên kết/phụ thuộc lẫn nhau mà không cần chỉ rõ các class cụ thể của nó.

Đ/n: abstract factory pattern cung cấp một cách để đóng gói một nhóm những cá thể factory có cùng một chủ đề mà không cần kai báo class cụ thể của chúng.

Sử dụng khi nào?: Khi có sự tương quan giữa phụ thuộc và các logic khởi tạo liên quan không đơn giản -->
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

    interface DoorFittingExpert {
        public function getDescription();
    }

    class Welder implements DoorFittingExpert {
        public function getDescription() {
            echo 'I can only fit iron doors';
        }
    }
    class Carpenter implements DoorFittingExpert {
        public function getDescription() {
            echo 'I can only fit wooden doors';
        }
    }

    interface DoorFactory {
        public function makeDoor(): Door;
        public function makeFittingExpert(): DoorFittingExpert;
    }

    // Wooden factory to return carpenter and wooden door
    class WoodenDoorFactory implements DoorFactory {
        public function makeDoor(): Door {
            return new WoodenDoor();
        }

        public function makeFittingExpert(): DoorFittingExpert {
            return new Carpenter();
        }
    }
    // Iron door factory to get iron door and the relevant fitting expert
    class IronDoorFactory implements DoorFactory {
        public function makeDoor(): Door {
            return new IronDoor();
        }

        public function makeFittingExpert(): DoorFittingExpert {
            return new Welder();
        }
    }

    $woodenFactory = new WoodenDoorFactory();
    $door = $woodenFactory->makeDoor();
    $expert = $woodenFactory->makeFittingExpert();
    $door->getDescription();  
    // Output: I am a wooden door
    $expert->getDescription(); 
    // Output: I can only fit wooden doors

    $ironFactory = new IronDoorFactory();
    $door = $ironFactory->makeDoor();
    $expert = $ironFactory->makeFittingExpert();
    $door->getDescription();  
    // Output: I am an iron door
    $expert->getDescription(); 
    // Output: I can only fit iron doors
?>



<!-- Builder
Tác dụng: Cho phép bạn bạn tạo các đặc điểm khác nhau của object trong khi tránh bị ảnh hưởng việc khởi tạo. Nó hữu dụng khi có thể tạo nhiều tùy chọn cho một object. Hoặc khi có quá nhiều bước trong việc tạo ra một object.

Đ/n: Builder pattern là một object thuộc nhóm design pattern khởi tạo phần mềm với ý tưởng tìm kiếm giải pháp chống lại việc khởi tạo

Sử dụng khi nào?: Khi có thể có một số đặc điểm của object và tránh việc chống lại khởi tạo. Sự khác biệt chính của factory pattern là đây; factory pattern được sử dụng khi việc khởi tạo chỉ có một bước trong tiến trình trong khi builder pattern được sử dụng khi có nhiều bước trong quá trình. -->
<?php
    // mô hình chống khởi tạo
    public function __construct($size, $cheese = true, $pepperoni = true, $tomato = false, $lettuce = true) {
        // code
    }

    // rewrite thay thế mô hình chống khởi tạo = Builder Pattern
    class Burger {
        protected $size;
        protected $cheese = false;
        protected $pepperoni = false;
        protected $lettuce = false;
        protected $tomato = false;
    
        public function __construct(BurgerBuilder $builder) {
            $this->size = $builder->size;
            $this->cheese = $builder->cheese;
            $this->pepperoni = $builder->pepperoni;
            $this->lettuce = $builder->lettuce;
            $this->tomato = $builder->tomato;
        }
    }

    class BurgerBuilder {
        public $size;
        public $cheese = false;
        public $pepperoni = false;
        public $lettuce = false;
        public $tomato = false;

        public function __construct(int $size) {
            $this->size = $size;
        }

        public function addPepperoni() {
            $this->pepperoni = true;
            return $this;
        }

        public function addLettuce() {
            $this->lettuce = true;
            return $this;
        }

        public function addCheese() {
            $this->cheese = true;
            return $this;
        }

        public function addTomato() {
            $this->tomato = true;
            return $this;
        }

        public function build(): Burger {
            return new Burger($this);
        }
    }

    $burger = ( new BurgerBuilder(14) ) ->addPepperoni()
                                        ->addLettuce()
                                        ->addTomato()
                                        ->build();
?>



<!-- Prototype
Tác dụng: Việc tạo object dựa trên một object đã tồn tại thông qua việc nhân bản. Nó cho phép bạn tạo một bản sao chép một object đã tồn tại và sửa đổi nó theo nhu cầu của bạn thay vì trải qua các sự cố khi tạo một object từ đầu và thiết lập lại nó.

Đ/n: Prototype pattern là một creational design pattern trong phát triển phần mềm. Nó được sử dụng khi kiểu của object cần tạo được định nghĩa bởi một thực thể nguyên mẫu, giống nhwu việc nhân bản nó để tạo ra một object mới.

Sử dụng khi nào?: Khi một object được yêu cầu phải tương tự như object hiện có hoặc khi việc khởi tạo mất nhiều công hơn việc nhân bản. -->
<?php
    class Sheep {
        protected $name;
        protected $category;

        public function __construct(string $name, string $category = 'Mountain Sheep') {
            $this->name = $name;
            $this->category = $category;
        }

        public function setName(string $name) {
            $this->name = $name;
        }

        public function getName() {
            return $this->name;
        }

        public function setCategory(string $category) {
            $this->category = $category;
        }

        public function getCategory() {
            return $this->category;
        }
    }

    $original = new Sheep('Jolly');
    echo $original->getName(); 
    // Output: Jolly
    echo $original->getCategory(); 
    // Output: Mountain Sheep

    // Clone and modify what is required
    $cloned = clone $original;
    $cloned->setName('Dolly');
    echo $cloned->getName(); 
    // Output: Dolly
    echo $cloned->getCategory(); 
    // Output: Mountain sheep
?>



<!-- Singleton
Tác dụng: Đảm bảo là chỉ có một đối tượng duy nhất của mỗi class được tạo ra.

Đ/n: Trong kĩ nghệ phần mềm, singleton pattern là một design pattern của phần mềm mà nó hạn chế sự khởi tạo của mỗi class chỉ thành một object. Điều này khá hữu dụng khi cần chính xác một object để điều phối các hành động trên hệ thống.

Sử dụng khi nào?: Để tạo ra một singleton, phải đặt private cho hàm khởi tạo, vô hiệu hóa việc nhân bản, vô hiệu hóa việc mở rộng và tạo ra các biến static để chứa các instance nhất định -->
<?php
    final class President {
        private static $instance;
    
        private function __construct() {
            // Hide the constructor
        }
    
        public static function getInstance(): President {
            if (!self::$instance) {
                self::$instance = new self();
            }
    
            return self::$instance;
        }
    
        private function __clone() {
            // Disable cloning
        }
    
        private function __wakeup() {
            // Disable unserialize
        }
    }

    $president1 = President::getInstance();
    $president2 = President::getInstance();
    // :: phân biệt thuộctính, phươngthức() là của lớp cha hay con khi kế thừa

    var_dump($president1 === $president2); 
    // Output: true
    // === so sánh 2 biến về giá trị và kiểu dữ liệu. cùng=true, khác=false
?>



2 - STRUCTURAL DESIGN PATTERNS

<!-- Adapter
Tác dụng: Adapter pattern cho phép bạn đóng gói một object không tương thích vào một adapter và giúp nó tương thích với một class khác

Đ/n: Trong kĩ nghệ phần mềm, adapter pattern là một design pattern trong lĩnh vực phần mềm cho phép interface của một class đã tồn tại có thể sử dụng được như một interface khác. Nó thường được sử dụng để giúp các class đã tồn tại làm việc được với những class khác mà không cần chỉnh sửa source code. -->
<?php
    interface Lion {
        public function roar();
    }
    
    class AfricanLion implements Lion {
        public function roar() {
            // code
        }
    }
    class AsianLion implements Lion {
        public function roar() {
            // code
        }
    }

    class Hunter {
        public function hunt(Lion $lion) {
            $lion->roar();
        }
    }
    class WildDog {
        public function bark() {
            // code
        }
    }

    // Adapter around wild dog to make it compatible with our game
    class WildDogAdapter implements Lion {
        protected $dog;

        public function __construct(WildDog $dog) {
            $this->dog = $dog;
        }

        public function roar() {
            $this->dog->bark();
        }
    }

    $wildDog = new WildDog();
    $wildDogAdapter = new WildDogAdapter($wildDog);

    $hunter = new Hunter();
    $hunter->hunt($wildDogAdapter);
?>



<!-- Bridge
Tác dụng: Bridge pattern thiên về mô hình composition thay vì inheritence (kế thừa). Chi tiết việc implement được đẩy từ một hệ thống phân cấp tới các object khác với hệ thống phân cấp riêng biệt.

Đ/n: Bridge pattern là một design pattern được sử dụng trong kĩ nghệ phần mềm mà nó được định nghĩa là "tách rời một lớp abstract từ implement của nó thành hai phần có thể thay đổi độc lập" -->
<?php
    interface WebPage {
        public function __construct(Theme $theme);
        public function getContent();
    }
    
    class About implements WebPage {
        protected $theme;
    
        public function __construct(Theme $theme) {
            $this->theme = $theme;
        }
    
        public function getContent() {
            return "About page in " . $this->theme->getColor();
        }
    }
    class Careers implements WebPage {
        protected $theme;
    
        public function __construct(Theme $theme) {
            $this->theme = $theme;
        }
    
        public function getContent() {
            return "Careers page in " . $this->theme->getColor();
        }
    }

    interface Theme {
        public function getColor();
    }

    class DarkTheme implements Theme {
        public function getColor() {
            return 'Dark Black';
        }
    }
    class LightTheme implements Theme {
        public function getColor() {
            return 'Off white';
        }
    }
    class AquaTheme implements Theme {
        public function getColor() {
            return 'Light blue';
        }
    }

    $darkTheme = new DarkTheme();
    $about = new About($darkTheme);
    $careers = new Careers($darkTheme);
    echo $about->getContent(); 
    // Output: "About page in Dark Black";
    echo $careers->getContent(); 
    // Output: "Careers page in Dark Black";
?>



<!-- Composite
Tác dụng: Composite pattern cho phép client xử lý các đối tượng theo một cách thống nhất

Đ/n: Trong kĩ nghệ phần mềm, composite pattern là một design pattern thuộc nhóm phân vùng. Composite pattern mô tả về một nhóm các object được xử lý cùng một cách giống như một instance của object. Mục đích của composite là "tạo ra" các object vào một cấu trúc dạng cây để đại diện cho toàn bộ hệ thống phân cấp. Việc triển khai composite pattern cho phép client xử lý các đối tượng và bố cục riêng lẻ một cách thống nhất. -->
<?php
    interface Employee {
        public function __construct(string $name, float $salary);
        public function getName(): string;
        public function setSalary(float $salary);
        public function getSalary(): float;
        public function getRoles(): array;
    }
    
    class Developer implements Employee {
        protected $salary;
        protected $name;
        protected $roles;
        
        public function __construct(string $name, float $salary) {
            $this->name = $name;
            $this->salary = $salary;
        }
    
        public function getName(): string {
            return $this->name;
        }
    
        public function setSalary(float $salary) {
            $this->salary = $salary;
        }
    
        public function getSalary(): float {
            return $this->salary;
        }
    
        public function getRoles(): array {
            return $this->roles;
        }
    }
    class Designer implements Employee {
        protected $salary;
        protected $name;
        protected $roles;
    
        public function __construct(string $name, float $salary) {
            $this->name = $name;
            $this->salary = $salary;
        }
    
        public function getName(): string {
            return $this->name;
        }
    
        public function setSalary(float $salary) {
            $this->salary = $salary;
        }
    
        public function getSalary(): float {
            return $this->salary;
        }
    
        public function getRoles(): array {
            return $this->roles;
        }
    }

    class Organization {
        protected $employees;
        public function addEmployee(Employee $employee) {
            $this->employees[] = $employee;
        }

        public function getNetSalaries(): float {
            $netSalary = 0;
            foreach ($this->employees as $employee) {
                $netSalary += $employee->getSalary();
            }
            return $netSalary;
        }
    }

    // Prepare the employees
    $john = new Developer('John Doe', 12000);
    $jane = new Designer('Jane Doe', 15000);
    
    // Add them to organization
    $organization = new Organization();
    $organization->addEmployee($john);
    $organization->addEmployee($jane);
    echo "Net salaries: " . $organization->getNetSalaries(); 
    // Output: Net Salaries: 27000
?>



<!-- Decorator
Tác dụng: Decorator pattern cho phép bạn tự động thay đổi các hành vi của một object ngay trong khi đang chạy bằng việc đóng gói chúng vào trong một object của một class decorator.

Đ/n: Trong lập trình hướng đối tượng, decorator pattern là một design pattern mà cho phép hành động thêm vào các object riêng lẻ, tĩnh hoặc động mà không ảnh hưởng lên hành vi của các object khác trong cùng class. Decorator pattern khá hữu dụng trong việc tôn trọng nguyên tắc Single Responsibility Principle, vì nó cho phép các chức năng được phân chia giữa các class mà nó quan tâm tới những khu vực duy nhất -->
<?php
    interface Coffee {
        public function getCost();
        public function getDescription();
    }
    
    class SimpleCoffee implements Coffee {
        public function getCost() {
            return 10;
        }
    
        public function getDescription() {
            return 'Simple coffee';
        }
    }

    class MilkCoffee implements Coffee {
        protected $coffee;
        public function __construct(Coffee $coffee) {
            $this->coffee = $coffee;
        }

        public function getCost() {
            return $this->coffee->getCost() + 2;
        }

        public function getDescription() {
            return $this->coffee->getDescription() . ', milk';
        }
    }

    class WhipCoffee implements Coffee {
        protected $coffee;
        public function __construct(Coffee $coffee) {
            $this->coffee = $coffee;
        }

        public function getCost() {
            return $this->coffee->getCost() + 5;
        }

        public function getDescription() {
            return $this->coffee->getDescription() . ', whip';
        }
    }

    class VanillaCoffee implements Coffee {
        protected $coffee;
        public function __construct(Coffee $coffee) {
            $this->coffee = $coffee;
        }

        public function getCost() {
            return $this->coffee->getCost() + 3;
        }

        public function getDescription() {
            return $this->coffee->getDescription() . ', vanilla';
        }
    }

    $someCoffee = new SimpleCoffee();
    echo $someCoffee->getCost(); 
    // Output: 10
    echo $someCoffee->getDescription(); 
    // Output: Simple Coffee

    $someCoffee = new MilkCoffee($someCoffee);
    echo $someCoffee->getCost(); 
    // Output: 12
    echo $someCoffee->getDescription(); 
    // Output: Simple Coffee, milk

    $someCoffee = new WhipCoffee($someCoffee);
    echo $someCoffee->getCost(); 
    // Output: 17
    echo $someCoffee->getDescription(); 
    // Output: Simple Coffee, milk, whip

    $someCoffee = new VanillaCoffee($someCoffee);
    echo $someCoffee->getCost(); 
    // Output: 20
    echo $someCoffee->getDescription(); 
    // Output: Simple Coffee, milk, whip, vanilla
?>



<!-- Facade
Tác dụng: Facade pattern cung cấp một một interface đơn giản để đại diện cho một hệ thống con

Đ/n: Một facade cung cấp một interface đơn giản hoá cho một phần code khá lớn, như là một class trong thư viện. -->
<?php
    class Computer {
        public function getElectricShock() {
            echo "Ouch!";
        }
    
        public function makeSound() {
            echo "Beep beep!";
        }
    
        public function showLoadingScreen() {
            echo "Loading..";
        }
    
        public function bam() {
            echo "Ready to be used!";
        }
    
        public function closeEverything() {
            echo "Bup bup bup buzzzz!";
        }
    
        public function sooth() {
            echo "Zzzzz";
        }
    
        public function pullCurrent() {
            echo "Haaah!";
        }
    }

    class ComputerFacade {
        protected $computer;
        public function __construct(Computer $computer) {
            $this->computer = $computer;
        }

        public function turnOn() {
            $this->computer->getElectricShock();
            $this->computer->makeSound();
            $this->computer->showLoadingScreen();
            $this->computer->bam();
        }

        public function turnOff() {
            $this->computer->closeEverything();
            $this->computer->pullCurrent();
            $this->computer->sooth();
        }
    }

    $computer = new ComputerFacade(new Computer());
    $computer->turnOn(); 
    // Output: Ouch! Beep beep! Loading.. Ready to be used!
    $computer->turnOff(); 
    // Output: Bup bup buzzz! Haah! Zzzzz
?>



<!-- Flyweight
Tác dụng: Nó được sử dụng để tối giản bộ nhớ hoặc chi phí về mặt tính toán thông qua việc chia sẻ nhiều nhất có thể với các object tương tự

Đ/n: Trong lĩnh vực phần mềm máy tính, flyweight là một design pattern của phần mềm. Một flyweight là một object mà tối giản bộ nhớ sử dụng bằng việc chia sẻ nhiều dât nhất có thể với các object tương tự; nó là một cách để sử dụng một lượng lớn các object khi việc biểu diễn đơn giản sẽ sử dụng lượng memory không thể chấp nhận được. -->
<?php
    class KarakTea {
        // code
    }
    
    // Acts as a factory and saves the tea
    class TeaMaker {
        protected $availableTea = [];
        public function make($preference) {
            if (empty($this->availableTea[$preference])) {
                $this->availableTea[$preference] = new KarakTea();
            }
            return $this->availableTea[$preference];
        }
    }

    class TeaShop {
        protected $orders;
        protected $teaMaker;
        public function __construct(TeaMaker $teaMaker) {
            $this->teaMaker = $teaMaker;
        }

        public function takeOrder(string $teaType, int $table) {
            $this->orders[$table] = $this->teaMaker->make($teaType);
        }

        public function serve() {
            foreach ($this->orders as $table => $tea) {
                echo "Serving tea to table# " . $table;
            }
        }
    }

    $teaMaker = new TeaMaker();
    $shop = new TeaShop($teaMaker);
    $shop->takeOrder('less sugar', 1);
    $shop->takeOrder('more milk', 2);
    $shop->takeOrder('without sugar', 5);
    $shop->serve();
    // Output: Serving tea to table# 1
    // Output: Serving tea to table# 2
    // Output: Serving tea to table# 5
?>



<!-- Proxy
Tác dụng: Việc sử dụng proxy pattern tức là sử dụng một class đại diện cho tính năng của class khác.

Đ/n: Một proxy, ở dạng tổng quát nhất của nó, là một lớp hoạt động như một giao diện cho một cái gì đó khác. Một proxy là một một đối tượng bao bọc hoặc agent đang được client gọi để truy cập đối tượng phục vụ thực đằng sau bối cảnh. Việc sử dụng proxy chỉ đơn giản là có thể chuyển tiếp đến đối tượng thực, hoặc có thể cung cấp thêm logic.Trong chức năng bổ sung proxy có thể được cung cấp, ví dụ bộ nhớ đệm khi các hoạt động trên đối tượng thực là tài nguyên sâu, hoặc kiểm tra điều kiện tiên quyết trước khi hoạt động trên đối tượng thực được gọi. -->
<?php
    interface Door {
        public function open();
        public function close();
    }
    
    class LabDoor implements Door {
        public function open() {
            echo "Opening lab door";
        }
    
        public function close() {
            echo "Closing the lab door";
        }
    }

    class SecuredDoor {
        protected $door;
        public function __construct(Door $door) {
            $this->door = $door;
        }

        public function open($password) {
            if ($this->authenticate($password)) {
                $this->door->open();
            } else {
                echo "Big no! It ain't possible.";
            }
        }

        public function authenticate($password) {
            return $password === '$ecr@t';
        }

        public function close() {
            $this->door->close();
        }
    }

    $door = new SecuredDoor(new LabDoor());
    $door->open('invalid'); 
    // Output: Big no! It ain't possible.
    $door->open('$ecr@t'); 
    // Output: Opening lab door
    $door->close(); 
    // Output: Closing lab door
?>



3 - BEHAVIORAL DESIGN PATTERNS

<!-- Chain of Responsibility
Tác dụng: It helps building a chain of objects. Request enters from one end and keeps going from object to object till it finds the suitable handler.

Đ/n: In object-oriented design, the chain-of-responsibility pattern is a design pattern consisting of a source of command objects and a series of processing objects. Each processing object contains logic that defines the types of command objects that it can handle; the rest are passed to the next processing object in the chain. -->
<?php
    abstract class Account {
        protected $successor;
        protected $balance;
    
        public function setNext(Account $account) {
            $this->successor = $account;
        }
    
        public function pay(float $amountToPay) {
            if ($this->canPay($amountToPay)) {
                echo sprintf('Paid %s using %s' . PHP_EOL, $amountToPay, get_called_class());
            } elseif ($this->successor) {
                echo sprintf('Cannot pay using %s. Proceeding ..' . PHP_EOL, get_called_class());
                $this->successor->pay($amountToPay);
            } else {
                throw new Exception('None of the accounts have enough balance');
            }
        }
    
        public function canPay($amount): bool {
            return $this->balance >= $amount;
        }
    }
    
    class Bank extends Account {
        protected $balance;
    
        public function __construct(float $balance) {
            $this->balance = $balance;
        }
    }
    
    class Paypal extends Account {
        protected $balance;
    
        public function __construct(float $balance) {
            $this->balance = $balance;
        }
    }
    
    class Bitcoin extends Account {
        protected $balance;
    
        public function __construct(float $balance) {
            $this->balance = $balance;
        }
    }

    // Bank with balance 100
    $bank = new Bank(100);          
    // Paypal with balance 200
    $paypal = new Paypal(200);      
    // Bitcoin with balance 300
    $bitcoin = new Bitcoin(300);    

    $bank->setNext($paypal);
    // Output: Cannot pay using bank. Proceeding ..
    $paypal->setNext($bitcoin);
    // Output: Cannot pay using paypal. Proceeding ..:
    $bank->pay(259);
    // Output: Paid 259 using Bitcoin!
?>



<!-- Command
Tác dụng: Allows you to encapsulate actions in objects. The key idea behind this pattern is to provide the means to decouple client from receiver.

Đ/n: In object-oriented programming, the command pattern is a behavioral design pattern in which an object is used to encapsulate all information needed to perform an action or trigger an event at a later time. This information includes the method name, the object that owns the method and values for the method parameters. -->
<?php
    class Bulb {
        public function turnOn() {
            echo "Bulb has been lit";
        }
    
        public function turnOff() {
            echo "Darkness!";
        }
    }

    interface Command {
        public function execute();
        public function undo();
        public function redo();
    }

    class TurnOn implements Command {
        protected $bulb;

        public function __construct(Bulb $bulb) {
            $this->bulb = $bulb;
        }

        public function execute() {
            $this->bulb->turnOn();
        }

        public function undo() {
            $this->bulb->turnOff();
        }

        public function redo() {
            $this->execute();
        }
    }

    class TurnOff implements Command {
        protected $bulb;

        public function __construct(Bulb $bulb) {
            $this->bulb = $bulb;
        }

        public function execute() {
            $this->bulb->turnOff();
        }

        public function undo() {
            $this->bulb->turnOn();
        }

        public function redo() {
            $this->execute();
        }
    }

    class RemoteControl {
        public function submit(Command $command) {
            $command->execute();
        }
    }

    $bulb = new Bulb();
    $turnOn = new TurnOn($bulb);
    $turnOff = new TurnOff($bulb);
    $remote = new RemoteControl();

    $remote->submit($turnOn); 
    // Output: Bulb has been lit!
    $remote->submit($turnOff); 
    // Output: Darkness!
?>



<!-- Iterator
Tác dụng: It presents a way to access the elements of an object without exposing the underlying presentation.

Đ/n: In object-oriented programming, the iterator pattern is a design pattern in which an iterator is used to traverse a container and access the container's elements. The iterator pattern decouples algorithms from containers; in some cases, algorithms are necessarily container-specific and thus cannot be decoupled. -->
<?php
    class RadioStation {
        protected $frequency;
    
        public function __construct(float $frequency) {
            $this->frequency = $frequency;
        }
    
        public function getFrequency(): float {
            return $this->frequency;
        }
    }

    use Countable;
    use Iterator;

    class StationList implements Countable, Iterator {
        protected $stations = [];
        protected $counter;

        public function addStation(RadioStation $station) {
            $this->stations[] = $station;
        }

        public function removeStation(RadioStation $toRemove) {
            $toRemoveFrequency = $toRemove->getFrequency();
            $this->stations = array_filter($this->stations, function (RadioStation $station) use ($toRemoveFrequency) {
                return $station->getFrequency() !== $toRemoveFrequency;
            });
        }

        public function count(): int {
            return count($this->stations);
        }

        public function current(): RadioStation {
            return $this->stations[$this->counter];
        }

        public function key() {
            return $this->counter;
        }

        public function next() {
            $this->counter++;
        }

        public function rewind() {
            $this->counter = 0;
        }

        public function valid(): bool {
            return isset($this->stations[$this->counter]);
        }
    }

    $stationList = new StationList();
    $stationList->addStation(new RadioStation(89));
    $stationList->addStation(new RadioStation(101));
    $stationList->addStation(new RadioStation(102));
    $stationList->addStation(new RadioStation(103.2));

    foreach($stationList as $station) {
        echo $station->getFrequency() . PHP_EOL;
    }

    $stationList->removeStation(new RadioStation(89)); 
    // Output: Will remove station 89
?>



<!-- Mediator
Tác dụng: Mediator pattern adds a third party object (called mediator) to control the interaction between two objects (called colleagues). It helps reduce the coupling between the classes communicating with each other. Because now they don't need to have the knowledge of each other's implementation.

Đ/n: In software engineering, the mediator pattern defines an object that encapsulates how a set of objects interact. This pattern is considered to be a behavioral pattern due to the way it can alter the program's running behavior. -->
<?php
    interface ChatRoomMediator  {
        public function showMessage(User $user, string $message);
    }
    
    class ChatRoom implements ChatRoomMediator {
        public function showMessage(User $user, string $message) {
            $time = date('M d, y H:i');
            $sender = $user->getName();
            echo $time . '[' . $sender . ']:' . $message;
        }
    }

    class User {
        protected $name;
        protected $chatMediator;
    
        public function __construct(string $name, ChatRoomMediator $chatMediator) {
            $this->name = $name;
            $this->chatMediator = $chatMediator;
        }
    
        public function getName() {
            return $this->name;
        }
    
        public function send($message) {
            $this->chatMediator->showMessage($this, $message);
        }
    }

    $mediator = new ChatRoom();
    $john = new User('John Doe', $mediator);
    $jane = new User('Jane Doe', $mediator);

    $john->send('Hi there!');
    // Output: Feb 14, 10:58 [John]: Hi there!
    $jane->send('Hey!');
    // Output: Feb 14, 10:58 [Jane]: Hey!
?>



<!-- Memento
Tác dụng: Memento pattern is about capturing and storing the current state of an object in a manner that it can be restored later on in a smooth manner.

Đ/n: The memento pattern is a software design pattern that provides the ability to restore an object to its previous state (undo via rollback). -->
<?php
    class EditorMemento {
        protected $content;
    
        public function __construct(string $content) {
            $this->content = $content;
        }
    
        public function getContent() {
            return $this->content;
        }
    }

    class Editor {
        protected $content = '';

        public function type(string $words) {
            $this->content = $this->content . ' ' . $words;
        }

        public function getContent() {
            return $this->content;
        }

        public function save() {
            return new EditorMemento($this->content);
        }

        public function restore(EditorMemento $memento) {
            $this->content = $memento->getContent();
        }
    }

    $editor = new Editor();

    // Type some stuff
    $editor->type('This is the first sentence.');
    $editor->type('This is second.');

    // Save the state to restore to : This is the first sentence. This is second.
    $saved = $editor->save();

    // Type some more
    $editor->type('And this is third.');

    echo $editor->getContent(); 
    // Output: This is the first sentence. This is second. And this is third.

    // Restoring to last saved state
    $editor->restore($saved);

    $editor->getContent(); 
    // Output: This is the first sentence. This is second.
?>



<!-- Observer
Tác dụng: Defines a dependency between objects so that whenever an object changes its state, all its dependents are notified.

Đ/n: The observer pattern is a software design pattern in which an object, called the subject, maintains a list of its dependents, called observers, and notifies them automatically of any state changes, usually by calling one of their methods. -->
<?php
    class JobPost {
        protected $title;
    
        public function __construct(string $title) {
            $this->title = $title;
        }
    
        public function getTitle() {
            return $this->title;
        }
    }
    
    class JobSeeker implements Observer {
        protected $name;
    
        public function __construct(string $name) {
            $this->name = $name;
        }
    
        public function onJobPosted(JobPost $job) {
            // Do something with the job posting
            echo 'Hi ' . $this->name . '! New job posted: '. $job->getTitle();
        }
    }

    class EmploymentAgency implements Observable {
        protected $observers = [];

        protected function notify(JobPost $jobPosting) {
            foreach ($this->observers as $observer) {
                $observer->onJobPosted($jobPosting);
            }
        }

        public function attach(Observer $observer) {
            $this->observers[] = $observer;
        }

        public function addJob(JobPost $jobPosting) {
            $this->notify($jobPosting);
        }
    }

    // Create subscribers
    $johnDoe = new JobSeeker('John Doe');
    $janeDoe = new JobSeeker('Jane Doe');

    // Create publisher and attach subscribers
    $jobPostings = new EmploymentAgency();
    $jobPostings->attach($johnDoe);
    $jobPostings->attach($janeDoe);

    // Add a new job and see if subscribers get notified
    $jobPostings->addJob(new JobPost('Software Engineer'));
    // Output: Hi John Doe! New job posted: Software Engineer
    // Output: Hi Jane Doe! New job posted: Software Engineer
?>



<!-- Visitor
Tác dụng: Visitor pattern lets you add further operations to objects without having to modify them.

Đ/n: In object-oriented programming and software engineering, the visitor design pattern is a way of separating an algorithm from an object structure on which it operates. A practical result of this separation is the ability to add new operations to existing object structures without modifying those structures. It is one way to follow the open/closed principle. -->
<?php
    // Visitee
    interface Animal {
        public function accept(AnimalOperation $operation);
    }

    // Visitor
    interface AnimalOperation {
        public function visitMonkey(Monkey $monkey);
        public function visitLion(Lion $lion);
        public function visitDolphin(Dolphin $dolphin);
    }

    class Monkey implements Animal {
        public function shout() {
            echo 'Ooh oo aa aa!';
        }

        public function accept(AnimalOperation $operation) {
            $operation->visitMonkey($this);
        }
    }

    class Lion implements Animal {
        public function roar() {
            echo 'Roaaar!';
        }

        public function accept(AnimalOperation $operation) {
            $operation->visitLion($this);
        }
    }

    class Dolphin implements Animal {
        public function speak() {
            echo 'Tuut tuttu tuutt!';
        }

        public function accept(AnimalOperation $operation) {
            $operation->visitDolphin($this);
        }
    }

    class Speak implements AnimalOperation {
        public function visitMonkey(Monkey $monkey) {
            $monkey->shout();
        }

        public function visitLion(Lion $lion) {
            $lion->roar();
        }

        public function visitDolphin(Dolphin $dolphin) {
            $dolphin->speak();
        }
    }

    $monkey = new Monkey();
    $lion = new Lion();
    $dolphin = new Dolphin();
    $speak = new Speak();

    $monkey->accept($speak);    
    // Output: Ooh oo aa aa!    
    $lion->accept($speak);      
    // Output: Roaaar!
    $dolphin->accept($speak);   
    // Output: Tuut tutt tuutt!

    class Jump implements AnimalOperation {
        public function visitMonkey(Monkey $monkey) {
            echo 'Jumped 20 feet high! on to the tree!';
        }

        public function visitLion(Lion $lion) {
            echo 'Jumped 7 feet! Back on the ground!';
        }

        public function visitDolphin(Dolphin $dolphin) {
            echo 'Walked on water a little and disappeared';
        }
    }

    $jump = new Jump();
    $monkey->accept($speak);   
    // Output: Ooh oo aa aa!
    $monkey->accept($jump);    
    // Output: Jumped 20 feet high! on to the tree!
    $lion->accept($speak);     
    // Output: Roaaar!
    $lion->accept($jump);      
    // Output: Jumped 7 feet! Back on the ground!
    $dolphin->accept($speak);  
    // Output: Tuut tutt tuutt!
    $dolphin->accept($jump);   
    // Output: Walked on water a little and disappeared
?>



<!-- Strategy
Tác dụng: Strategy pattern allows you to switch the algorithm or strategy based upon the situation.

Đ/n: In computer programming, the strategy pattern (also known as the policy pattern) is a behavioural software design pattern that enables an algorithm's behavior to be selected at runtime. -->
<?php
    interface SortStrategy {
        public function sort(array $dataset): array;
    }
    
    class BubbleSortStrategy implements SortStrategy {
        public function sort(array $dataset): array {
            echo "Sorting using bubble sort";
            return $dataset;
        }
    }
    
    class QuickSortStrategy implements SortStrategy {
        public function sort(array $dataset): array {
            echo "Sorting using quick sort";
            return $dataset;
        }
    }

    class Sorter {
        protected $sorter;

        public function __construct(SortStrategy $sorter) {
            $this->sorter = $sorter;
        }

        public function sort(array $dataset): array {
            return $this->sorter->sort($dataset);
        }
    }

    $dataset = [1, 5, 4, 3, 2, 8];
    $sorter = new Sorter(new BubbleSortStrategy());
    $sorter = new Sorter(new QuickSortStrategy());

    $sorter->sort($dataset); 
    // Output : Sorting using bubble sort
    $sorter->sort($dataset); 
    // Output : Sorting using quick sort
?>



<!-- State
Tác dụng: It lets you change the behavior of a class when the state changes.

Đ/n: The state pattern is a behavioral software design pattern that implements a state machine in an object-oriented way. With the state pattern, a state machine is implemented by implementing each individual state as a derived class of the state pattern interface, and implementing state transitions by invoking methods defined by the pattern's superclass. The state pattern can be interpreted as a strategy pattern which is able to switch the current strategy through invocations of methods defined in the pattern's interface. -->
<?php
    interface WritingState {
        public function write(string $words);
    }
    
    class UpperCase implements WritingState {
        public function write(string $words) {
            echo strtoupper($words);
        }
    }
    
    class LowerCase implements WritingState {
        public function write(string $words) {
            echo strtolower($words);
        }
    }
    
    class DefaultText implements WritingState {
        public function write(string $words) {
            echo $words;
        }
    }

    class TextEditor {
        protected $state;

        public function __construct(WritingState $state) {
            $this->state = $state;
        }

        public function setState(WritingState $state) {
            $this->state = $state;
        }

        public function type(string $words) {
            $this->state->write($words);
        }
    }

    $editor = new TextEditor(new DefaultText());
    $editor->type('First line');
    // Output: First line

    $editor->setState(new UpperCase());
    $editor->type('Second line');
    // Output: SECOND LINE
    $editor->type('Third line');
    // Output: THIRD LINE

    $editor->setState(new LowerCase());
    $editor->type('Fourth line');
    // Output: fourth line
    $editor->type('Fifth line');
    // Output: fifth line
?>



<!-- Template Method
Tác dụng: Template method defines the skeleton of how a certain algorithm could be performed, but defers the implementation of those steps to the children classes.

Đ/n: In software engineering, the template method pattern is a behavioral design pattern that defines the program skeleton of an algorithm in an operation, deferring some steps to subclasses. It lets one redefine certain steps of an algorithm without changing the algorithm's structure. -->
<?php
    abstract class Builder {
        // Template method
        final public function build() {
            $this->test();
            $this->lint();
            $this->assemble();
            $this->deploy();
        }
    
        abstract public function test();
        abstract public function lint();
        abstract public function assemble();
        abstract public function deploy();
    }

    class AndroidBuilder extends Builder {
        public function test() {
            echo 'Running android tests';
        }

        public function lint() {
            echo 'Linting the android code';
        }

        public function assemble() {
            echo 'Assembling the android build';
        }

        public function deploy() {
            echo 'Deploying android build to server';
        }
    }

    class IosBuilder extends Builder {
        public function test() {
            echo 'Running ios tests';
        }

        public function lint() {
            echo 'Linting the ios code';
        }

        public function assemble() {
            echo 'Assembling the ios build';
        }

        public function deploy() {
            echo 'Deploying ios build to server';
        }
    }

    $androidBuilder = new AndroidBuilder();
    $androidBuilder->build();
    // Output: Running android tests
    // Output: Linting the android code
    // Output: Assembling the android build
    // Output: Deploying android build to server

    $iosBuilder = new IosBuilder();
    $iosBuilder->build();
    // Output: Running ios tests
    // Output: Linting the ios code
    // Output: Assembling the ios build
    // Output: Deploying ios build to server
?>