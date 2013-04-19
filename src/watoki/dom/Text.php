<?php
namespace watoki\dom;
 
class Text extends Node {

    public static $CLASS = __CLASS__;

    private $content;

    function __construct($content) {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->content;
    }

}
