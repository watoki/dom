<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Attribute;

class DoubleQuotedAttributeValueState extends QuotedAttributeValueState {

    public static $CLASS = __CLASS__;

    public function onDoubleQuote($char) {
        return $this->onQuote(Attribute::QUOTE_DOUBLE);
    }
}
