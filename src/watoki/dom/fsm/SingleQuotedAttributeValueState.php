<?php
namespace watoki\dom\fsm;
 
class SingleQuotedAttributeValueState extends State {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->attributeValue .= $char;
        return self::$CLASS;
    }

    public function onSingleQuote($char) {
        $this->buffer->attributes->set($this->buffer->attributeName, $this->buffer->attributeValue);
        $this->buffer->attributeName = '';
        $this->buffer->attributeValue = '';
        return ElementState::$CLASS;
    }
}
