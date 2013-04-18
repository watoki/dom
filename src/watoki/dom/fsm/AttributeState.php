<?php
namespace watoki\dom\fsm;

use watoki\dom\Attribute;

class AttributeState extends ElementState {

    public function onGreaterThan($char) {
        $this->setAttribute();
        return parent::onGreaterThan($char);
    }

    public function onSlash($char) {
        $this->setAttribute();
        return parent::onSlash($char);
    }

    public function onAlphaNumeric($char) {
        return $this->onOther($char);
    }

    public function onWhiteSpace($char) {
        $this->setAttribute();
        return parent::onWhiteSpace($char);
    }

    protected function setAttribute() {
        $attribute = new Attribute($this->buffer->attributeName, $this->buffer->attributeValue);
        $this->buffer->attributes->append($attribute);
        $this->buffer->attributeName = '';
        $this->buffer->attributeValue = '';
        return $attribute;
    }

}