<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;

class ClosingElementNameState extends State {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        if ($this->buffer->name != $this->buffer->element->getName()) {
            throw new \Exception("Unmatched elements: {$this->buffer->element->getName()} and {$this->buffer->name}");
        }

        $this->buffer->element = $this->buffer->element->getParent();
        return NullState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
