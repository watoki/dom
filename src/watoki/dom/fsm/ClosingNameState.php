<?php
namespace watoki\dom\fsm;
 
class ClosingNameState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        return $this->onElse($char);
    }

    public function onGreaterThan($char) {
        if ($this->buffer->name != $this->buffer->potentialParent->getName()) {
            throw new \Exception('Mismatched closing tag: ' . $this->buffer->name);
        }
        return NullState::$CLASS;
    }

    public function onSlash($char) {
        return $this->onElse($char);
    }

    public function onSpace($char) {
        return $this->onElse($char);
    }

    public function onEndOfInput($char) {
        return $this->onElse($char);
    }

    public function onElse($char) {
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
