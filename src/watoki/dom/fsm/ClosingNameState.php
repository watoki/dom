<?php
namespace watoki\dom\fsm;
 
use watoki\dom\Element;

class ClosingNameState extends State {

    public static $CLASS = __CLASS__;

    public function onGreaterThan($char) {
        $children = array();
        while ($potentialParent = array_pop($this->buffer->potentialParents)) {
            if ($potentialParent instanceof Element && $this->buffer->name == $potentialParent->getName()) {
                foreach ($children as $child) {
                    $this->buffer->element->getChildren()->remove($this->buffer->element->getChildren()->indexOf($child));
                    $potentialParent->getChildren()->append($child);
                }
                $this->buffer->potentialParents[] = $potentialParent;
                $this->buffer->name = '';
                return NullState::$CLASS;
            } else {
                array_unshift($children, $potentialParent);
            }
        }
        throw new \Exception('Mismatched closing tag: ' . $this->buffer->name);
    }

    public function onOther($char) {
        $this->buffer->name .= $char;
        return self::$CLASS;
    }
}
