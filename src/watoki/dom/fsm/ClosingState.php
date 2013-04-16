<?php
namespace watoki\dom\fsm;
 
class ClosingState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        return $this->onElse($char);
    }

    public function onGreaterThan($char) {
        return $this->onElse($char);
    }

    public function onSlash($char) {
        return $this->onElse($char);
    }

    public function onSpace($char) {
        return $this->onElse($char);
    }

    public function onEndOfInput($char) {
        return $this->onElse($char);
    }

    public function onElse($char) {
        $this->buffer->name .= $char;
        return ClosingNameState::$CLASS;
    }
}
