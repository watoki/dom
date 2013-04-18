<?php
namespace watoki\dom\fsm;

class AttributeValueState extends AttributeState {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        return $this->onOther($char);
    }

    public function onOther($char) {
        $this->buffer->attributeValue .= $char;
        return static::$CLASS;
    }

    public function onDoubleQuote($char) {
        return DoubleQuotedAttributeValueState::$CLASS;
    }

    public function onSingleQuote($char) {
        return SingleQuotedAttributeValueState::$CLASS;
    }
}
