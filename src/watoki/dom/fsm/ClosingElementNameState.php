<?php
namespace watoki\dom\fsm;
 
class ClosingElementNameState extends ClosingElementState {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
