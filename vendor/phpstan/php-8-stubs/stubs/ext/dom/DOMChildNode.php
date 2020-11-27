<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\DOMChildNode', 'DOMChildNode', \false);
