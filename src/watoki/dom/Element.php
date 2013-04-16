<?php
namespace watoki\dom;
 
use watoki\collections\Liste;
use watoki\collections\Map;
use watoki\collections\events\ListCreateEvent;

class Element extends Node {

    public static $CLASS = __CLASS__;

    private $name;

    private $attributes;

    private $children;

    function __construct($name, Map $attributes = null) {
        $this->name = $name;
        $this->attributes = $attributes ?: new Map();
        $this->children = new Liste();

        $that = $this;
        $this->children->on(ListCreateEvent::$CLASSNAME, function (ListCreateEvent $e) use ($that) {
            /** @var $node Node */
            $node = $e->getElement();
            $node->setParent($that);
        });
    }

    /**
     * @return Liste|Node[]
     */
    public function getChildren() {
        return $this->children;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * @return Map
     */
    public function getAttributes() {
        return $this->attributes;
    }

}
