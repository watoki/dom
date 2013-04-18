<?php
namespace spec\watoki\dom;

class ParseNodeTest extends ParseTest {

    function testTextNode() {
        $this->when->iParse('Hello World');
        $this->then->theResultShouldBe('[
            { "text":"Hello World" }
        ]');
    }

    function testClosedElement() {
        $this->when->iParse('<closed/>');
        $this->then->theResultShouldBe('[
            { "element":"closed" }
        ]');
    }

    function testEmptyElement() {
        $this->when->iParse('<empty></empty>');
        $this->then->theResultShouldBe('[
            { "element":"empty" }
        ]');
    }

    function testEmptyAndClosed() {
        $this->when->iParse('<one></one><two/>');
        $this->then->theResultShouldBe('[
            { "element":"one" },
            { "element":"two" }
        ]');
    }

    function testUnclosedElement() {
        $this->when->iTryToParse('<unclosed>');
        $this->then->theResultShouldBe('[
            { "element":"unclosed" }
        ]');
    }

    function testUnmatched() {
        $this->when->iTryToParse('<one></two>');
        $this->then->anExceptionShouldBeThrownContaining('one');
    }

    function testMalFormed() {
        $this->when->iParse('<one<two/>/>');
        $this->then->theResultShouldBe('[
            { "text":"<one" },
            { "element":"two" },
            { "text":"/>" }
        ]');
    }

    function testMalFormedWithSpace() {
        $this->when->iParse('<one <two/>/>');
        $this->then->theResultShouldBe('[
            { "text":"<one " },
            { "element":"two" },
            { "text":"/>" }
        ]');
    }

    function testStartsWithSpace() {
        $this->when->iParse('< div/>');
        $this->then->theResultShouldBe('[
            { "text":"< div/>" }
        ]');
    }

    function testStartsWithNoneLetter() {
        $this->when->iParse('<!not an element>');
        $this->then->theResultShouldBe('[
            { "text":"<!not an element>" }
        ]');
    }

    function testCaseSensitive() {
        $this->when->iParse('<Element></Element>');
        $this->then->theResultShouldBe('[
            { "element":"Element" }
        ]');
    }

}