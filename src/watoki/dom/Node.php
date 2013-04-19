<?php
namespace watoki\dom;
 
class Node {

    public static $CLASS = __CLASS__;

    private $parent;

    /**
     * @return Element
     */
    public function getParent() {
        return $this->parent;
    }

    public function setParent(Node $parent) {
        $this->parent = $parent;
    }

    public function unsetParent() {
        $this->parent = null;
    }

}
