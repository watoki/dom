<?php
namespace watoki\dom;
 
class Text extends Node {

    public static $CLASS = __CLASS__;

    private $text;

    function __construct($text) {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

}
