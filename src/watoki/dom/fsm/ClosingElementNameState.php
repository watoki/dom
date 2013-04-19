<?php
namespace watoki\dom\fsm;
 
class ClosingElementNameState extends ClosingElementState {

    public static $CLASS = __CLASS__;

    public function onOther($char) {
        $this->buffer->addToElementName($char);
        return self::$CLASS;
    }
}
