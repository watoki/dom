<?php
namespace watoki\dom\fsm;
 
class NullState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->buffer->text .= $char;
        return BeginState::$CLASS;
    }

    public function onEndOfInput($char) {
        return self::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }
}
