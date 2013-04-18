<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Attribute;

class SingleQuotedAttributeValueState extends QuotedAttributeValueState {

    public static $CLASS = __CLASS__;

    public function onSingleQuote($char) {
        return $this->onQuote(Attribute::QUOTE_SINGLE);
    }
}
