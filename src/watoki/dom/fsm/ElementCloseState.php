<?php
namespace watoki\dom\fsm;

class ElementCloseState extends ElementState {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        $element = $this->appendElement();
        $element->setHasClosingTag(false);
        return NullState::$CLASS;
    }

    public function onAlphaNumeric($char) {
        return $this->onOther($char);
    }

    public function onOther($char) {
        return self::$CLASS;
    }
}
