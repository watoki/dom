# dom [![Build Status](https://travis-ci.org/watoki/dom.png?branch=master)](https://travis-ci.org/watoki/dom)

A very simple (X)HTML/XML parser for PHP. It's goal is that the not manipulated output is as close as possible to the input. This means
that it will parse most invalid mark-up without complains.

## Usage ##

Include *dom* into your project with [composer] and then:

    $parser = new Parser('<my>Custom <html></html></my>');
    $parser->getNodes()->first()->setName('Your');
    $printer = new Printer();
    echo $printer->printNodes($parser->getNodes()); // <Your>Custom <html></html></Your>

[composer]: http://getcomposer.org/