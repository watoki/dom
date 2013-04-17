<?php
namespace watoki\dom\fsm;

abstract class QuotedAttributeValueState extends State {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->attributeValue .= $char;
        return static::$CLASS;
    }

    protected function onQuote($char) {
        $this->buffer->attributes->set($this->buffer->attributeName, $this->buffer->attributeValue);
        $this->buffer->attributeName = '';
        $this->buffer->attributeValue = '';
        return ElementState::$CLASS;
    }

}