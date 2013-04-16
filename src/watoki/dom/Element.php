<?php
namespace watoki\dom;
 
use watoki\collections\Liste;
use watoki\collections\events\ListCreateEvent;

class Element extends Node {

    public static $CLASS = __CLASS__;

    private $name;

    private $children;

    function __construct($name) {
        $this->name = $name;
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

}
