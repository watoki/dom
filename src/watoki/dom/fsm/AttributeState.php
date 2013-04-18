<?php
namespace watoki\dom\fsm;

class AttributeState extends ElementState {

    public function onGreaterThan($char) {
        $this->setAttribute();
        return parent::onGreaterThan($char);
    }

    public function onSlash($char) {
        $this->setAttribute();
        return parent::onSlash($char);
    }

    protected function setAttribute() {
        $this->buffer->attributes->set($this->buffer->attributeName, $this->buffer->attributeValue);
        $this->buffer->attributeName = '';
        $this->buffer->attributeValue = '';
    }

}