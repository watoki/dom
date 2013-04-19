<?php
namespace watoki\dom\fsm;

class AttributeNameState extends AttributeState {

    public static $CLASS = __CLASS__;

    public function onEquals($char) {
        return AttributeValueState::$CLASS;
    }

    public function onOther($char) {
        $this->buffer->addToAttributeName($char);
        return self::$CLASS;
    }
}
