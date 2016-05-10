<?php
namespace watoki\dom\fsm;

class AttributeValueState extends AttributeState {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        return $this->onOther($char);
    }

    public function onOther($char) {
        $this->buffer->addToAttributeValue($char);
        return static::$CLASS;
    }

    public function onDoubleQuote($char) {
        $this->buffer->addToAttributeValue('');
        return DoubleQuotedAttributeValueState::$CLASS;
    }

    public function onSingleQuote($char) {
        $this->buffer->addToAttributeValue('');
        return SingleQuotedAttributeValueState::$CLASS;
    }
}
