<?php
namespace watoki\dom\fsm;

abstract class QuotedAttributeValueState extends AttributeValueState {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        return $this->onOther($char);
    }

    public function onSlash($char) {
        return $this->onOther($char);
    }

    public function onWhiteSpace($char) {
        return $this->onOther($char);
    }

    protected function onQuote($quoting) {
        $attribute = parent::setAttribute();
        $attribute->setQuoting($quoting);
        return ElementState::$CLASS;
    }

}