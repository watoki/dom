<?php
namespace spec\watoki\dom;

use watoki\dom\Parser;
use watoki\dom\Printer;

/**
 * @property PrinterTest_When when
 * @property PrinterTest_Then then
 */
class PrinterTest extends Test {

    function testText() {
        $this->when->iPrintTheMarkup('Hello World');
        $this->then->itShouldPrint('Hello World');
    }

    function testUnclosedElement() {
        $this->when->iPrintTheMarkup('<element>');
        $this->then->itShouldPrint('<element/>');
    }

    function testClosedElement() {
        $this->when->iPrintTheMarkup('<element/>');
        $this->then->itShouldPrint('<element/>');
    }

    function testEmptyElement() {
        $this->when->iPrintTheMarkup('<element></element>');
        $this->then->itShouldPrint('<element></element>');
    }

    function testChildren() {
        $this->when->iPrintTheMarkup('<element><child/>And Text</element>');
        $this->then->itShouldPrint('<element><child/>And Text</element>');
    }

    function testWhiteSpacing() {
        $this->when->iPrintTheMarkup('
        <element>
            <child/>
            And Text
        </element>');
        $this->then->itShouldPrint('
        <element>
            <child/>
            And Text
        </element>');
    }

    function testAttributes() {
        $this->when->iPrintTheMarkup('<element unquoted=value single=\'quoted\' quoted="value"/>');
        $this->then->itShouldPrint('<element unquoted=value single=\'quoted\' quoted="value"/>');
    }

    function testEmptyAttributes() {
        $this->when->iPrintTheMarkup('<element empty quoted="" single=\'\'/>');
        $this->then->itShouldPrint('<element empty quoted="" single=\'\'/>');
    }
}

/**
 * @property PrinterTest test
 */
class PrinterTest_When extends Test_When {

    public $result;

    public function iPrintTheMarkup($string) {
        $parser = new Parser($string);
        $printer = new Printer();
        $this->result = $printer->printNodes($parser->getNodes());
    }
}

/**
 * @property PrinterTest test
 */
class PrinterTest_Then extends Test_Then {

    public function itShouldPrint($string) {
        $this->test->assertEquals($string, $this->test->when->result);
    }
}
