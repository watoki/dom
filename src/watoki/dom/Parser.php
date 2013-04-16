<?php
namespace watoki\dom;

class Parser {

    const STATE_NULL = 0;

    const STATE_TEXT = 1;

    const STATE_BEGIN  = 2;

    const STATE_NAME = 3;

    const STATE_END = 4;

    const STATE_CLOSING = 5;

    const STATE_CLOSING_NAME = 6;

    const STATE_ELEMENT = 7;

    static $CLASS = __CLASS__;

    private $content;

    /**
     * @var Element
     */
    private $element;

    /**
     * @var Element
     */
    private $potentialParent;

    private $text = '';

    public $name = '';

    function __construct($content) {
        $this->content = $content;
    }

    public function getNodes() {
        if (!$this->element) {
            $this->parse();
        }
        return $this->element->getChildren();
    }

    private function parse() {
        $root = new Element('root');
        $this->element = $root;

        $state = self::STATE_TEXT;

        for ($i = 0; $i < strlen($this->content); $i++) {
            $state = $this->input($state, $this->content[$i]);
        }
        $this->input($state, null);

        return $root;
    }

    private function input($state, $char) {
        switch ($state) {

            case self::STATE_NULL:
                switch ($char) {
                    case '<':
                        return self::STATE_BEGIN;
                    case null:
                        return self::STATE_NULL;
                    default:
                        $this->text .= $char;
                        return self::STATE_TEXT;
                }
                break;

            case self::STATE_TEXT:
                switch ($char) {
                    case '<':
                        $this->text .= $char;
                        return self::STATE_BEGIN;
                    case null:
                        $this->element->getChildren()->append(new Text($this->text));
                        return self::STATE_TEXT;
                    default:
                        $this->text .= $char;
                        return self::STATE_TEXT;
                }
                break;

            case self::STATE_BEGIN:
                switch ($char) {
                    case '/':
                        return self::STATE_CLOSING;
                    case ' ':
                        $this->text .= $char;
                        return self::STATE_TEXT;
                    default:
                        $this->text .= $char;
                        $this->name = $char;
                        return self::STATE_NAME;
                }
                break;

            case self::STATE_NAME:
                switch ($char) {
                    case '>':
                        $element = new Element($this->name);
                        $this->element->getChildren()->append($element);
                        $this->text = '';
                        $this->name = '';
                        $this->potentialParent = $element;
                        return self::STATE_NULL;
                    case '/':
                        return self::STATE_END;
                    case '<':
                        $this->element->getChildren()->append(new Text($this->text));
                        $this->text = '';
                        return self::STATE_BEGIN;
                    case ' ':
                        $this->text .= $char;
                        return self::STATE_ELEMENT;
                    default:
                        $this->text .= $char;
                        $this->name .= $char;
                        return self::STATE_NAME;
                }
                break;

            case self::STATE_ELEMENT:
                switch ($char) {
                    case '<':
                        $this->element->getChildren()->append(new Text($this->text));
                        $this->text = '';
                        return self::STATE_BEGIN;
                }
                break;

            case self::STATE_END:
                switch ($char) {
                    case '>':
                        $this->element->getChildren()->append(new Element($this->name));
                        $this->text = '';
                        $this->name = '';
                        return self::STATE_NULL;
                }
                break;

            case self::STATE_CLOSING:
                switch ($char) {
                    default:
                        $this->name .= $char;
                        return self::STATE_CLOSING_NAME;
                }
                break;

            case self::STATE_CLOSING_NAME:
                switch ($char) {
                    case '>':
                        if ($this->name != $this->potentialParent->getName()) {
                            throw new \Exception('Mismatched closing tag: ' . $this->name);
                        }
                        return self::STATE_NULL;
                    default:
                        $this->name .= $char;
                        return self::STATE_CLOSING_NAME;
                }
                break;
        }

        throw new \Exception('Unknown state: ' . $state);
    }

}
