<?php
namespace spec\watoki\dom;

class ParseChildrenTest extends Test {

    function testChildren() {
        $this->when->iParse('<father><son/><daughter/></father>');
        $this->then->theResultShouldBe('[
            {   "element":"father",
                "children":[
                    { "element":"son" },
                    { "element":"daughter" }
                ]
            }
        ]');
    }

    function testEmptyChild() {
        $this->when->iTryToParse('<one><two></two></one>');
        $this->then->theResultShouldBe('[
            {   "element":"one",
                "children":[
                    { "element":"two" }
                ]
            }
        ]');
    }

    function testTextChild() {
        $this->when->iParse('<text>Some Text</text>');
        $this->then->theResultShouldBe('[
            {   "element":"text",
                "children":[
                    { "text":"Some Text" }
                ]
            }
        ]');
    }

    function testGrandChild() {
        $this->when->iParse('<one><two><three/></two></one>');
        $this->then->theResultShouldBe('[
            {   "element":"one",
                "children":[
                    {   "element":"two",
                        "children":[
                            { "element":"three" }
                        ]
                    }
                ]
            }
        ]');
    }

}