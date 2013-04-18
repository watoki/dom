<?php
namespace watoki\dom\fsm;
 
use watoki\collections\Liste;
use watoki\dom\Attribute;
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
     * @var Liste|Attribute[]
     */
    public $attributes;

    function __construct() {
        $this->attributes = new Liste();
    }

}
