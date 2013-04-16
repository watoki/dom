<?php
namespace watoki\dom\fsm;
 
abstract class State {

    public static $CLASS = __CLASS__;

    protected $buffer;

    function __construct(Buffer $buffer) {
        $this->buffer = $buffer;
    }

    abstract public function onOther($char);

    public function onLessThan($char) {
        return $this->onOther($char);
    }

    public function onGreaterThan($char) {
        return $this->onOther($char);
    }

    public function onSlash($char) {
        return $this->onOther($char);
    }

    public function onWhiteSpace($char) {
        return $this->onOther($char);
    }

    public function onEndOfInput($char) {
        return $this->onOther($char);
    }

    public function onDoubleQuote($char) {
        return $this->onOther($char);
    }

    public function onSingleQuote($char) {
        return $this->onOther($char);
    }

    public function onEquals($char) {
        return $this->onOther($char);
    }

}
