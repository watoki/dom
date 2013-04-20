<?php
namespace spec\watoki\dom;

class ParseAttributeTest extends ParseTest {

    function testNoValue() {
        $this->when->iParse('<novalue empty/>');
        $this->then->theResultShouldBe('[
            {   "element":"novalue",
                "attributes":[
                    {   "name":"empty",
                        "value":null
                    }
                ]
            }
        ]');
    }

    function testNoQuotes() {
        $this->when->iParse("<none some=thing/>");
        $this->then->theResultShouldBe('[
            {   "element":"none",
                "attributes":[
                    {   "name":"some",
                        "value":"thing"
                    }
                ]
            }
        ]');
    }

    function testDoubleQuotes() {
        $this->when->iParse('<hasvalue value="something"/>');
        $this->then->theResultShouldBe('[
            {   "element":"hasvalue",
                "attributes":[
                    {   "name":"value",
                        "value":"something"
                    }
                ]
            }
        ]');
    }

    function testSpacesInQuotedAttribute() {
        $this->when->iParse('<spaces that="has a space"/>');
        $this->then->theResultShouldBe('[
            {   "element":"spaces",
                "attributes":[
                    {   "name":"that",
                        "value":"has a space"
                    }
                ]
            }
        ]');
    }

    function testEmptyValue() {
        $this->when->iParse('<empty value=""/>');
        $this->then->theResultShouldBe('[
            {   "element":"empty",
                "attributes":[
                    {   "name":"value",
                        "value":""
                    }
                ]
            }
        ]');
    }

    function testSingleQuotes() {
        $this->when->iParse("<single some='thing'/>");
        $this->then->theResultShouldBe('[
            {   "element":"single",
                "attributes":[
                    {   "name":"some",
                        "value":"thing"
                    }
                ]
            }
        ]');
    }

    function testMultiple() {
        $this->when->iParse('<many novalue cero=zero uno=\'one\' dos="two"/>');
        $this->then->theResultShouldBe('[
            {   "element":"many",
                "attributes":[
                    {   "name":"novalue",
                        "value":null
                    },
                    {   "name":"cero",
                        "value":"zero"
                    },
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
        $this->when->iParse('<quoted element="<value/>"/>');
        $this->then->theResultShouldBe('[
            {   "element":"quoted",
                "attributes":[
                    {   "name":"element",
                        "value":"<value/>"
                    }
                ]
            }
        ]');
    }

    function testUnquotedElement() {
        $this->when->iParse('<unquoted element=<value/>>');
        $this->then->theResultShouldBe('[
            {   "element":"unquoted",
                "attributes":[
                    {   "name":"element",
                        "value":"<value"
                    }
                ]
            },
            {   "text":">"
            }
        ]');
    }

    function testNonAlphaNumericName() {
        $this->when->iParse('<e =value/>');
        $this->then->theResultShouldBe('[
            { "text":"<e =value/>" }
        ]');
    }

    function testWithAndWithout() {
        $this->when->iParse('<without/><with name="value"/>');
        $this->then->theResultShouldBe('[
            {   "element":"without"
            },
            {   "element":"with",
                "attributes":[
                    {   "name":"name",
                        "value":"value"
                    }
                ]
            }
        ]');
    }

    function testSpecialCharacters() {
        $this->when->iParse('<special double="some(special = \'characters\'?)" single=\'Here "Too"\'/>');
        $this->then->theResultShouldBe('[
            {   "element":"special",
                "attributes":[
                    {   "name":"double",
                        "value":"some(special = \'characters\'?)"
                    },
                    {   "name":"single",
                        "value":"Here \"Too\""
                    }
                ]
            }
        ]');
    }

}