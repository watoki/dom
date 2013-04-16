<?php
namespace watoki\dom\fsm;
 
class ClosingState extends State {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->name .= $char;
        return ClosingNameState::$CLASS;
    }
}
