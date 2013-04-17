<?php
namespace watoki\dom\fsm;
 
class SingleQuotedAttributeValueState extends QuotedAttributeValueState {

    public static $CLASS = __CLASS__;

    public function onSingleQuote($char) {
        return $this->onQuote($char);
    }
}
