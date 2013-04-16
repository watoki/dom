<?php
namespace spec\watoki\dom;

class ParseNodeTest extends Test {

    function testTextNode() {
        $this->when->iParse('Hello World');
        $this->then->theResultShouldBe('[
            { "content":"Hello World" }
        ]');
    }

    function testUnclosedElement() {
        $this->when->iParse('<unclosed>');
        $this->then->theResultShouldBe('[
            { "name":"unclosed" }
        ]');
    }

    function testClosedElement() {
        $this->when->iParse('<closed/>');
        $this->then->theResultShouldBe('[
            { "name":"closed" }
        ]');
    }

    function testEmptyElement() {
        $this->when->iParse('<empty></empty>');
        $this->then->theResultShouldBe('[
            { "name":"empty" }
        ]');
    }

    function testUnclosedAndClosed() {
        $this->when->iParse('<one><two/>');
        $this->then->theResultShouldBe('[
            { "name":"one" },
            { "name":"two" }
        ]');
    }

    function testUnmatched() {
        $this->when->iTryToParse('<one></two>');
        $this->then->anExceptionShouldBeThrownContaining('two');
    }

    function testMalFormed() {
        $this->when->iParse('<one<two/>>');
        $this->then->theResultShouldBe('[
            { "content":"<one" },
            { "name":"two" },
            { "content":">" }
        ]');
    }

    function testMalFormedWithSpace() {
        $this->when->iParse('<one <two/>>');
        $this->then->theResultShouldBe('[
            { "content":"<one " },
            { "name":"two" },
            { "content":">" }
        ]');
    }

    function testStartsWithSpace() {
        $this->when->iParse('< div>');
        $this->then->theResultShouldBe('[
            { "content":"< div>" }
        ]');
    }

    function testCaseSensitive() {
        $this->when->iParse('<Element></Element>');
        $this->then->theResultShouldBe('[
            { "name":"Element" }
        ]');
    }

}