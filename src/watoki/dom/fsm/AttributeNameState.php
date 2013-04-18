<?php
namespace watoki\dom\fsm;

use watoki\dom\Element;

class AttributeNameState extends State {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        $this->buffer->attributes->set($this->buffer->attributeName, $this->buffer->attributeValue);
        $this->buffer->element->getChildren()->append(new Element($this->buffer->name, $this->buffer->attributes));
        return NullState::$CLASS;
    }

    public function onSlash($char) {
        $this->buffer->attributes->set($this->buffer->attributeName, $this->buffer->attributeValue);
        return ElementCloseState::$CLASS;
    }

    public function onEquals($char) {
        return AttributeValueState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->attributeName .= $char;
        return self::$CLASS;
    }
}
