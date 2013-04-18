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
        $this->buffer = new Buffer();
    }

    public function getNodes() {
        if (!$this->root) {
            $this->root = $this->parse();
        }
        return $this->root->getChildren();
    }

    private function parse() {
        $root = new Element('root');

        $state = $this->getState(NullState::$CLASS);
        $this->buffer->element = $root;

        for ($i = 0; $i < strlen($this->content); $i++) {
            $state = $this->getState($this->input($state, $this->content[$i]));
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
                return $state->onOther($char);
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

}
