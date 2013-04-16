<?php
namespace watoki\dom\fsm;
 
class ClosingNameState extends State {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        if ($this->buffer->name != $this->buffer->potentialParent->getName()) {
            throw new \Exception('Mismatched closing tag: ' . $this->buffer->name);
        }
        return NullState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
