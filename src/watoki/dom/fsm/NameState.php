<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;
use watoki\dom\Text;

class NameState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->buffer->element->getChildren()->append(new Text($this->buffer->text));
        $this->buffer->text = '';
        return BeginState::$CLASS;
    }

    public function onGreaterThan($char) {
        $element = new Element($this->buffer->name);
        $this->buffer->element->getChildren()->append($element);
        $this->buffer->text = '';
        $this->buffer->name = '';
        $this->buffer->potentialParent = $element;
        return NullState::$CLASS;
    }

    public function onSlash($char) {
        return EndState::$CLASS;
    }

    public function onWhiteSpace($char) {
        $this->buffer->text .= $char;
        return ElementState::$CLASS;
    }

    public function onEndOfInput($char) {
        return $this->onOther($char);
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
