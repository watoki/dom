<?php
namespace watoki\dom\fsm;
 
class ClosingElementState extends State {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->name .= $char;
        return ClosingElementNameState::$CLASS;
    }
}
