<?php
namespace watoki\dom\fsm;
 
use watoki\collections\Map;
use watoki\dom\Element;

class Buffer {

    public static $CLASS = __CLASS__;

    /**
     * @var Element
     */
    public $element;

    /**
     * @var array|Element[]
     */
    public $potentialParents = array();

    public $text = '';

    public $name = '';

    public $attributeName = '';

    public $attributeValue;

    /**
     * @var Map|string[]|null[]
     */
    public $attributes;

    function __construct() {
        $this->attributes = new Map();
    }

}
