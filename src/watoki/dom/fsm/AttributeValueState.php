<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;

class AttributeValueState extends State {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->attributeValue .= $char;
        return self::$CLASS;
    }

    public function onGreaterThan($char) {
        $this->buffer->attributes->set($this->buffer->attributeName, $this->buffer->attributeValue);
        $this->buffer->element->getChildren()->append(new Element($this->buffer->name, $this->buffer->attributes));
        $this->buffer->attributeName = '';
        $this->buffer->attributeValue = '';
        $this->buffer->name = '';
        $this->buffer->text = '';
        return NullState::$CLASS;
    }

    public function onDoubleQuote($char) {
        return DoubleQuotedAttributeValueState::$CLASS;
    }

    public function onSingleQuote($char) {
        return SingleQuotedAttributeValueState::$CLASS;
    }
}
