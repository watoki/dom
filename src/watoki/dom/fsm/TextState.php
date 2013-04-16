<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Text;

class TextState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->buffer->text .= $char;
        return BeginState::$CLASS;
    }

    public function onEndOfInput($char) {
        $this->buffer->element->getChildren()->append(new Text($this->buffer->text));
        return TextState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }
}
