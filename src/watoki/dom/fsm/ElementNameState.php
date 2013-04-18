<?php
namespace watoki\dom\fsm;

class ElementNameState extends ElementState {

    public static $CLASS = __CLASS__;

    public function onWhiteSpace($char) {
        $this->buffer->text .= $char;
        return ElementState::$CLASS;
    }

    public function onAlphaNumeric($char) {
        return $this->onOther($char);
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
