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

    public function onOther($char) {
        $this->buffer->text .= $char;
        $this->buffer->attributeName = $char;
        return AttributeNameState::$CLASS;
    }
}
