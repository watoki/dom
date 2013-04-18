<?php
namespace watoki\dom;
 
use watoki\collections\Liste;

class Printer {

    public static $CLASS = __CLASS__;

    /**
     * @param Liste|Node[] $nodes
     * @return string
     */
    public function printNodes(Liste $nodes) {
        $out = '';
        foreach ($nodes as $node) {
            if ($node instanceof Text) {
                $out .= $this->printText($node);
            } else if ($node instanceof Element) {
                $out .= $this->printElement($node);
            }
        }
        return $out;
    }

    private function printText(Text $node) {
        return $node->getContent();
    }

    private function printElement(Element $node) {
        $out = '<' . $node->getName();

        foreach ($node->getAttributes() as $name => $value) {
            $out .= ' ' . $name;

            if ($value !== null) {
                $out .= '="' . $value . '"';
            }
        }

        if ($node->getChildren()->isEmpty()) {
            return $out . '/>';
        } else {
            return $out . '>' . $this->printNodes($node->getChildren()) . '</' . $node->getName() . '>';
        }
    }

}
