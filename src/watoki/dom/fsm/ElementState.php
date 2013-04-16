<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Text;

class ElementState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->buffer->element->getChildren()->append(new Text($this->buffer->text));
        $this->buffer->text = '';
        return BeginState::$CLASS;
    }

    public function onGreaterThan($char) {
        return $this->onElse($char);
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
        $this->buffer->text .= $char;
        $this->buffer->attributeName = $char;
        return AttributeNameState::$CLASS;
    }
}
