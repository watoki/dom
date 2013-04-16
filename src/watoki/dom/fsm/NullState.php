<?php
namespace watoki\dom\fsm;
 
class NullState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->buffer->text .= $char;
        return BeginState::$CLASS;
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
        return self::$CLASS;
    }

    public function onElse($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }
}
