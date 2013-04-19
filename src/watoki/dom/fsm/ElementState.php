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
        $this->buffer->pushElement();
        return NullState::$CLASS;
    }

    public function onAlphaNumeric($char) {
        $this->buffer->addToText($char);
        $this->buffer->addToAttributeName($char);
        return AttributeNameState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->addToText($char);
        return TextState::$CLASS;
    }

    public function onWhiteSpace($char) {
        return self::$CLASS;
    }

    protected function appendElement() {
        return $this->buffer->appendElement();
    }
}
