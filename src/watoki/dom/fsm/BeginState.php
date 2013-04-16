<?php
namespace watoki\dom\fsm;
 
class BeginState extends State {

    public static $CLASS = __CLASS__;

    public function onSlash($char) {
        return ClosingState::$CLASS;
    }

    public function onSpace($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        $this->buffer->name = $char;
        return NameState::$CLASS;
    }
}
