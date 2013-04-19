<?php
namespace spec\watoki\dom;

use watoki\collections\Liste;
use watoki\dom\Element;
use watoki\dom\Node;
use watoki\dom\Parser;
use watoki\dom\Printer;
use watoki\dom\Text;

/**
 * @property ManipulationTest_Given given
 * @property ManipulationTest_When when
 * @property ManipulationTest_Then then
 */
class ManipulationTest extends Test {

    function testRenamingElement() {
        $this->given->theMarkUp('<some/><element></element>');
        $this->when->nodes[0]->setName('other');
        $this->when->nodes[1]->setName('stuff');
        $this->then->itShouldBe('<other/><stuff></stuff>');
    }

    function testSetTextContent() {
        $this->given->theMarkUp('Some Text');
        $this->when->nodes[0]->setText('Other Content');
        $this->then->itShouldBe('Other Content');
    }

    function testDeletingChild() {
        $this->given->theMarkUp('<father><child/><sister/><brother/></father>');
        $child = $this->when->nodes[0]->getChildren()->get(1);
        $this->when->nodes[0]->getChildren()->removeElement($child);
        $this->then->itShouldBe('<father><child/><brother/></father>');
    }

    function testDeletingAttribute() {
        $this->given->theMarkUp('<one/><two some="stuff" other="value"/>');
        $this->when->nodes[1]->getAttributes()->removeElement($this->when->nodes[1]->getAttribute('some'));
        $this->then->itShouldBe('<one/><two other="value"/>');
    }

    function testCopyingElement() {
        $this->given->theMarkUp('<dad><child prop=thing><other>Stuff</other></child></dad>');

        /** @var Element $copy */
        $dad = $this->when->nodes[0];
        $copy = $dad->getChildren()->first()->copy();
        $copy->setName('brother');
        $copy->setAttribute('prop', 'thang');
        $copy->getChildren()->first()->getChildren()->first()->setText('Other');
        $dad->getChildren()->append($copy);

        $this->then->itShouldBe('<dad><child prop=thing><other>Stuff</other></child><brother prop=thang><other>Other</other></brother></dad>');
        $this->assertTrue($copy->getChildren()->first()->getParent() === $copy);
    }

}

/**
 * @property ManipulationTest test
 */
class ManipulationTest_Given extends Test_Given {

    public function theMarkUp($string) {
        $parser = new Parser($string);
        $this->test->when->nodes = $parser->getNodes();
    }
}

/**
 * @property ManipulationTest test
 */
class ManipulationTest_When extends Test_When {

    /**
     * @var Liste|Node[]|Element[]|Text[]
     */
    public $nodes;

}

/**
 * @property ManipulationTest test
 */
class ManipulationTest_Then extends Test_Then {

    public function itShouldBe($string) {
        $printer = new Printer();
        $this->test->assertEquals($string, $printer->printNodes($this->test->when->nodes));
    }
}