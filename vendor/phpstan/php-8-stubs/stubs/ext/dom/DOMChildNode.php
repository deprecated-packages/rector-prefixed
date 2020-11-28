<?php

namespace _PhpScoperabd03f0baf05;

interface DOMChildNode
{
    public function remove() : void;
    /** @param DOMNode|string $nodes */
    public function before(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function after(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function replaceWith(...$nodes) : void;
}
\class_alias('_PhpScoperabd03f0baf05\\DOMChildNode', 'DOMChildNode', \false);
