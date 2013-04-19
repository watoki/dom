<?php
namespace watoki\dom;
 
class Attribute {

    public static $CLASS = __CLASS__;

    const QUOTE_NONE = 0;
    const QUOTE_SINGLE = 1;
    const QUOTE_DOUBLE = 2;

    private $name;

    private $value;

    private $quoting;

    function __construct($name, $value = null, $quoting = self::QUOTE_NONE) {
        $this->name = $name;
        $this->value = $value;
        $this->quoting = $quoting;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getQuoting() {
        return $this->quoting;
    }

    public function setQuoting($quoting) {
        $this->quoting = $quoting;
    }

    public function copy() {
        return new Attribute($this->name, $this->value, $this->quoting);
    }

}
