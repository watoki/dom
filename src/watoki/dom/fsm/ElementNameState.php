<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;
use watoki\dom\Text;

class ElementNameState extends ElementState {

    public static $CLASS = __CLASS__;

    public function onWhiteSpace($char) {
        $this->buffer->text .= $char;
        return ElementState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
