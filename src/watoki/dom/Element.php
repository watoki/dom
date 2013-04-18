<?php
namespace watoki\dom;
 
use watoki\collections\Liste;
use watoki\collections\events\ListCreateEvent;

class Element extends Node {

    public static $CLASS = __CLASS__;

    private $name;

    /**
     * @var \watoki\collections\Liste|Attribute[]
     */
    private $attributes;

    private $children;

    private $hasClosingTag = false;

    function __construct($name, Liste $attributes = null) {
        $this->name = $name;
        $this->attributes = $attributes ?: new Liste();
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

    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return Liste|Attribute[]
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * @param $name
     * @return null|\watoki\dom\Attribute
     */
    public function getAttribute($name) {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getName() == $name) {
                return $attribute;
            }
        }
        return null;
    }

    public function setAttribute($name, $value) {
        $attribute = $this->getAttribute($name);
        if (!$attribute) {
            $this->attributes->append(new Attribute($name, $value));
        } else {
            $attribute->setValue($value);
        }
    }

    public function hasClosingTag() {
        return $this->hasClosingTag;
    }

    public function setHasClosingTag($has) {
        $this->hasClosingTag = $has;
    }

}
