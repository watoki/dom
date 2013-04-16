<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;

class EndState extends State {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        $this->buffer->element->getChildren()->append(new Element($this->buffer->name));
        $this->buffer->text = '';
        $this->buffer->name = '';
        return NullState::$CLASS;
    }

    public function onOther($char) {
        return self::$CLASS;
    }
}
