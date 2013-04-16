<?php
namespace spec\watoki\dom;

class ParseAttributeTest extends Test {

    function testNoValue() {
        $this->when->iParse('<novalue empty>');
        $this->then->theResultShouldBe('[
            {   "name":"novalue",
                "attributes":[
                    {   "name":"empty",
                        "value":null
                    }
                ]
            }
        ]');
    }

    function testWithValue() {
        $this->when->iParse('<hasvalue value="something">');
        $this->then->theResultShouldBe('[
            {   "name":"hasvalue",
                "attributes":[
                    {   "name":"value",
                        "value":"something"
                    }
                ]
            }
        ]');
    }

    function testEmptyValue() {
        $this->when->iParse('<empty value="">');
        $this->then->theResultShouldBe('[
            {   "name":"empty",
                "attributes":[
                    {   "name":"value",
                        "value":""
                    }
                ]
            }
        ]');
    }

    function testSingleQuotes() {
        $this->when->iParse("<single some='thing'>");
        $this->then->theResultShouldBe('[
            {   "name":"single",
                "attributes":[
                    {   "name":"some",
                        "value":"thing"
                    }
                ]
            }
        ]');
    }

    function testNoQuotes() {
        $this->when->iParse("<none some=thing>");
        $this->then->theResultShouldBe('[
            {   "name":"none",
                "attributes":[
                    {   "name":"some",
                        "value":"thing"
                    }
                ]
            }
        ]');
    }

    function testMultiple() {
        $this->when->iParse('<many uno="one" dos="two">');
        $this->then->theResultShouldBe('[
            {   "name":"many",
                "attributes":[
                    {   "name":"uno",
                        "value":"one"
                    },
                    {   "name":"dos",
                        "value":"two"
                    }
                ]
            }
        ]');
    }

    function testQuotedElement() {
        $this->when->iParse('<quoted element="<value>">');
        $this->then->theResultShouldBe('[
            {   "name":"quoted",
                "attributes":[
                    {   "name":"element",
                        "value":"<value>"
                    }
                ]
            }
        ]');
    }

    function testUnquotedElement() {
        $this->when->iParse('<unquoted element=<value>>');
        $this->then->theResultShouldBe('[
            {   "name":"unquoted",
                "attributes":[
                    {   "name":"element",
                        "value":"<value"
                    }
                ]
            },
            {   "content":">"
            }
        ]');
    }

}