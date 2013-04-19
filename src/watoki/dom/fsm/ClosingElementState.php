<?php
namespace watoki\dom\fsm;
 
class ClosingElementState extends TextState {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        $this->buffer->popElement();
        return NullState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->addToElementName($char);
        return ClosingElementNameState::$CLASS;
    }
}
