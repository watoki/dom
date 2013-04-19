<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Text;

class TextState extends NullState {

    public static $CLASS = __CLASS__;

    public function onLessThan($char) {
        $this->pushText($char);
        return parent::onLessThan($char);
    }

    public function onEndOfInput() {
        $this->pushText();
    }

    protected function pushText() {
        $this->buffer->pushText();
    }
}
