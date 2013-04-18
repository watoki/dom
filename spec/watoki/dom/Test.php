<?php
namespace spec\watoki\dom;

/**
 * @property Test_Given given
 * @property Test_When when
 * @property Test_Then then
 */
abstract class Test extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        foreach (array('given', 'when', 'then') as $steps) {
            $testClass = get_class($this);
            while ($testClass) {
                $class = $testClass . '_' . ucfirst($steps);
                if (class_exists($class)) {
                    $this->$steps = new $class($this);
                    break;
                }

                $refl = new \ReflectionClass($testClass);
                $testClass = $refl->getParentClass()->getName();
            }
        }
    }

}

class Test_Given {

    function __construct(Test $test) {
        $this->test = $test;
    }
}

class Test_When {

    /**
     * @var \Exception|null
     */
    public $caught;

    function __construct(Test $test) {
        $this->test = $test;
    }

}

class Test_Then {

    function __construct(Test $test) {
        $this->test = $test;
    }

    public function anExceptionShouldBeThrownContaining($msg) {
        $this->test->assertNotNull($this->test->when->caught);
        $this->test->assertContains($msg, $this->test->when->caught->getMessage());
    }

}