<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;
use watoki\dom\Text;

class ElementState extends State {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->buffer->element->getChildren()->append(new Text($this->buffer->text));
        $this->buffer->text = '';
        return BeginState::$CLASS;
    }

    public function onGreaterThan($char) {
        $element = new Element($this->buffer->name, $this->buffer->attributes);
        $this->buffer->element->getChildren()->append($element);
        $this->buffer->text = '';
        $this->buffer->name = '';
        $this->buffer->potentialParents[] = $element;
        return NullState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->text .= $char;
        $this->buffer->attributeName = $char;
        return AttributeNameState::$CLASS;
    }

    public function onWhiteSpace($char) {
        return self::$CLASS;
    }
}
