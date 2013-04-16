<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Text;

class TextState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $element = new Text($this->buffer->text);
        $this->buffer->element->getChildren()->append($element);
        $this->buffer->potentialParents[] = $element;
        $this->buffer->text = $char;
        return BeginState::$CLASS;
    }

    public function onEndOfInput($char) {
        $element = new Text($this->buffer->text);
        $this->buffer->element->getChildren()->append($element);
        $this->buffer->potentialParents[] = $element;
        return TextState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        return TextState::$CLASS;
    }
}
