<?php
namespace watoki\dom\fsm;
 
class DoubleQuotedAttributeValueState extends QuotedAttributeValueState {

    public static $CLASS = __CLASS__;

    public function onDoubleQuote($char) {
        return $this->onQuote();
    }
}
