<?php
namespace spec\watoki\dom;

use watoki\collections\Liste;
use watoki\dom\Element;
use watoki\dom\Node;
use watoki\dom\Parser;
use watoki\dom\Text;

/**
 * @property ParseTest_When when
 * @property ParseTest_Then then
 */
abstract class ParseTest extends Test {


}

/**
 * @property ParseTest test
 */
class ParseTest_When extends Test_When {

    /**
     * @var Liste|Node[]
     */
    public $nodes;

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

/**
 * @property ParseTest test
 */
class ParseTest_Then extends Test_Then {

    public function theResultShouldBe($json) {
        $results = array();
        foreach ($this->test->when->nodes as $node) {
            $results[] = $this->convertNode($node);
        }
        $this->test->assertEquals(json_decode($json, true), $results);
    }

    private function convertNode($node) {
        if ($node instanceof Text) {
            return array('text' => $node->getContent());
        } else if ($node instanceof Element) {
            $result = array(
                'element' => $node->getName()
            );

            if (!$node->getAttributes()->isEmpty()) {
                $attributes = array();
                foreach ($node->getAttributes() as $attribute) {
                    $attributes[] = array(
                        'name' => $attribute->getName(),
                        'value' => $attribute->getValue()
                    );
                }
                $result['attributes'] = $attributes;
            }

            if (!$node->getChildren()->isEmpty()) {
                $children = array();
                foreach ($node->getChildren() as $child) {
                    $children[] = $this->convertNode($child);
                }
                $result['children'] = $children;
            }

            return $result;
        }

        throw new \Exception;
    }

    public function anExceptionShouldBeThrownContaining($msg) {
        $this->test->assertNotNull($this->test->when->caught);
        $this->test->assertContains($msg, $this->test->when->caught->getMessage());
    }

}
