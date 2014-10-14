<?php
namespace watoki\dom\fsm;

use watoki\collections\Liste;
use watoki\dom\Attribute;
use watoki\dom\Element;
use watoki\dom\Text;

class Buffer {

    public static $CLASS = __CLASS__;

    /**
     * @var Element
     */
    private $element;

    /**
     * @var Element
     */
    private $nextElement;

    /**
     * @var Attribute
     */
    private $nextAttribute;

    private $nextText;

    function __construct(Element $root) {
        $this->element = $root;
        $this->reset();
    }

    public function reset() {
        $this->resetText();
        $this->resetElement();
    }

    public function resetText() {
        $this->nextText = '';
    }

    public function resetElement() {
        $this->nextElement = new Element('');
        $this->resetAttribute();
    }

    public function resetAttribute() {
        return $this->nextAttribute = new Attribute('');
    }

    public function addToElementName($char) {
        $this->nextElement->setName($this->nextElement->getName() . $char);
    }

    public function appendElement() {
        $element = $this->nextElement;
        $this->element->getChildren()->append($element);
        $this->reset();
        return $element;
    }

    public function addToAttributeName($char) {
        $this->nextAttribute->setName($this->nextAttribute->getName() . $char);
    }

    public function addToAttributeValue($char) {
        $this->nextAttribute->setValue($this->nextAttribute->getValue() . $char);
    }

    public function appendAttribute() {
        $attribute = $this->nextAttribute;
        $this->nextElement->getAttributes()->append($attribute);

        $this->resetAttribute();
        return $attribute;
    }

    public function pushText() {
        $this->element->getChildren()->append(new Text($this->nextText));
        $this->reset();
    }

    public function addToText($char) {
        $this->nextText .= $char;
    }

    public function pushElement() {
        $this->element = $this->appendElement();
    }

    public function popElement() {
        if ($this->nextElement->getName() != $this->element->getName()) {
            throw new \Exception("Unmatched elements: {$this->element->getName()} and {$this->nextElement->getName()}");
        }

        $this->element->setHasClosingTag(true);
        $this->element = $this->element->getParent();

        $this->reset();
    }

    /**
     * @return \watoki\dom\Element
     */
    public function getNextElement() {
        return $this->nextElement;
    }

}
