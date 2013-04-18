<?php
namespace watoki\dom\fsm;
 
class ElementBeginState extends TextState {

    public static $CLASS = __CLASS__;

    public function onSlash($char) {
        return ClosingElementState::$CLASS;
    }

    public function onWhiteSpace($char) {
        return parent::onOther($char);
    }

    public function onAlphaNumeric($char) {
        parent::onOther($char);
        $this->buffer->name = $char;
        return ElementNameState::$CLASS;
    }
}
