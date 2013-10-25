<?php
namespace watoki\dom;

use watoki\dom\fsm\Buffer;
use watoki\dom\fsm\NullState;
use watoki\dom\fsm\State;

class Parser {

    static $CLASS = __CLASS__;

    /**
     * @var Element
     */
    public $root;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array|State[]
     */
    private $statePool = array();

    /**
     * @var Buffer
     */
    private $buffer;

    function __construct($content) {
        $this->content = $content;
    }

    public function getNodes() {
        return $this->getRoot()->getChildren();
    }

    private function getRoot() {
        if (!$this->root) {
            $this->root = $this->parse();
        }
        return $this->root;
    }

    private function parse() {
        $root = new Element('root');
        $this->buffer = new Buffer($root);

        $state = $this->getState(NullState::$CLASS);

        for ($i = 0; $i < strlen($this->content); $i++) {
            try {
                $state = $this->getState($this->input($state, $this->content[$i]));
            } catch (\Exception $e) {
                throw new \Exception('Error: "' . $e->getMessage() . '" while parsing near [...]'
                    . substr($this->content, $i - 70, 140) . '[...]');
            }
        }
        $this->input($state, null);

        return $root;
    }

    private function input(State $state, $char) {
        switch ($char) {
            case '<':
                return $state->onLessThan($char);
            case '>':
                return $state->onGreaterThan($char);
            case '/':
                return $state->onSlash($char);
            case '"':
                return $state->onDoubleQuote($char);
            case "'":
                return $state->onSingleQuote($char);
            case '=':
                return $state->onEquals($char);
            case ' ':
            case "\n":
            case "\r":
            case "\t":
                return $state->onWhiteSpace($char);
            case null:
                return $state->onEndOfInput();
            default:
                if (ctype_alnum($char)) {
                    return $state->onAlphaNumeric($char);
                } else {
                    return $state->onOther($char);
                }
        }
    }

    /**
     * @param $class
     * @throws \Exception
     * @return State
     */
    private function getState($class) {
        if (!isset($this->statePool[$class])) {
            if (!class_exists($class)) {
                throw new \Exception('Unknown class: ' . $class);
            }
            $this->statePool[$class] = new $class($this->buffer);
        }
        return $this->statePool[$class];
    }

    public function findElement($name) {
        return $this->getRoot()->findChildElement($name);
    }

}
