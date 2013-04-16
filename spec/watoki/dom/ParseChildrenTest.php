<?php
namespace spec\watoki\dom;

class ParseChildrenTest extends Test {

    function testChildren() {
        $this->when->iParse('<father><son><daughter></father>');
        $this->then->theResultShouldBe('[
            {   "name":"father",
                "children":[
                    { "name":"son" },
                    { "name":"daughter" }
                ]
            }
        ]');
    }

    function testTextChild() {
        $this->when->iParse('<text>Some Text</text>');
        $this->then->theResultShouldBe('[
            {   "name":"text",
                "children":[
                    { "content":"Some Text" }
                ]
            }
        ]');
    }

    function testGrandChild() {
        $this->when->iParse('<one><two><three></two></one>');
        $this->then->theResultShouldBe('[
            {   "name":"one",
                "children":[
                    {   "name":"two",
                        "children":[
                            { "name":"three" }
                        ]
                    }
                ]
            }
        ]');
    }

}