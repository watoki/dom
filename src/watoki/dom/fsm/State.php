<?php
namespace watoki\dom\fsm;
 
abstract class State {

    public static $CLASS = __CLASS__;

    protected $buffer;

    function __construct(Buffer $buffer) {
        $this->buffer = $buffer;
    }

    abstract public function onLessThan($char);

    abstract public function onGreaterThan($char);

    abstract public function onSlash($char);

    abstract public function onSpace($char);

    abstract public function onEndOfInput($char);

    abstract public function onElse($char);

}
