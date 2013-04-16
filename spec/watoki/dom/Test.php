<?php
namespace spec\watoki\dom;

use watoki\collections\Liste;
use watoki\dom\Element;
use watoki\dom\Node;
use watoki\dom\Parser;
use watoki\dom\Text;

/**
 * @property Test_Given given
 * @property Test_When when
 * @property Test_Then then
 */
abstract class Test extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        foreach (array('given', 'when', 'then') as $steps) {
            $class = get_class($this) . '_' . ucfirst($steps);
            if (class_exists($class)) {
                $this->$steps = new $class($this);
            } else {
                $class = __CLASS__ . '_' . ucfirst($steps);
                $this->$steps = new $class($this);
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
     * @var Liste|Node[]
     */
    public $nodes;

    /**
     * @var \Exception|null
     */
    public $caught;

    function __construct(Test $test) {
        $this->test = $test;
    }

    public function iParse($string) {
        $parser = new Parser($string);
        $this->nodes = $parser->getNodes();
    }

    public function iTryToParse($string) {
        try {
            $this->iParse($string);
        } catch (\Exception $e) {
            $this->caught = $e;
        }
    }

}

class Test_Then {

    function __construct(Test $test) {
        $this->test = $test;
    }

    public function theResultShouldBe($json) {
        $result = array();
        foreach ($this->test->when->nodes as $node) {
            if ($node instanceof Text) {
                $result[] = array('content' => $node->getContent());
            } else if ($node instanceof Element) {
                $result[] = array(
                    'name' => $node->getName()
                );
            }
        }
        $this->test->assertEquals(json_decode($json, true), $result);
    }

    public function anExceptionShouldBeThrownContaining($msg) {
        $this->test->assertNotNull($this->test->when->caught);
        $this->test->assertContains($msg, $this->test->when->caught->getMessage());
    }

}