<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;
use watoki\dom\Text;

class ElementState extends TextState {

    public static $CLASS = __CLASS__;

    public function onSlash($char) {
        return ElementCloseState::$CLASS;
    }

    public function onGreaterThan($char) {
        $this->buffer->element = $this->appendElement();
        return NullState::$CLASS;
    }

    public function onAlphaNumeric($char) {
        $this->buffer->text .= $char;
        $this->buffer->attributeName = $char;
        return AttributeNameState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }

    public function onWhiteSpace($char) {
        return self::$CLASS;
    }

    protected function appendElement() {
        $element = new Element($this->buffer->name, $this->buffer->attributes);
        $this->buffer->element->getChildren()->append($element);
        $this->buffer->text = '';
        $this->buffer->name = '';
        return $element;
    }
}
