<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;

class EndState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        return $this->onElse($char);
    }

    public function onGreaterThan($char) {
        $this->buffer->element->getChildren()->append(new Element($this->buffer->name));
        $this->buffer->text = '';
        $this->buffer->name = '';
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
        return self::$CLASS;
    }
}
