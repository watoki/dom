<?php
namespace watoki\dom\fsm;

class ElementNameState extends ElementState {

    public static $CLASS = __CLASS__;

    public function onWhiteSpace($char) {
        $this->buffer->addToText($char);
        return ElementState::$CLASS;
    }

    public function onAlphaNumeric($char) {
        return $this->onOther($char);
    }

    public function onOther($char) {
        $this->buffer->addToText($char);
        $this->buffer->addToElementName($char);
        return self::$CLASS;
    }
}
