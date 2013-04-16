<?php
namespace watoki\dom\fsm;
 
class BeginState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        return $this->onElse($char);
    }

    public function onGreaterThan($char) {
        return $this->onElse($char);
    }

    public function onSlash($char) {
        return ClosingState::$CLASS;
    }

    public function onSpace($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }

    public function onEndOfInput($char) {
        return $this->onElse($char);
    }

    public function onElse($char) {
        $this->buffer->text .= $char;
        $this->buffer->name = $char;
        return NameState::$CLASS;
    }
}
