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

        foreach ($node->getAttributes() as $attribute) {
            $out .= ' ' . $attribute->getName();

            if ($attribute->getValue() !== null) {
                $quotes = $this->printQuotes($attribute->getQuoting());
                $out .= '=' . $quotes . $attribute->getValue() . $quotes;
            }
        }

        if (!$node->getChildren()->isEmpty() || $node->hasClosingTag()) {
            return $out . '>' . $this->printNodes($node->getChildren()) . '</' . $node->getName() . '>';
        } else {
            return $out . '/>';
        }
    }

    private function printQuotes($quoting) {
        switch ($quoting) {
            case Attribute::QUOTE_NONE:
                return '';
            case Attribute::QUOTE_SINGLE:
                return "'";
            case Attribute::QUOTE_DOUBLE:
            default:
                return '"';
        }
    }

}
