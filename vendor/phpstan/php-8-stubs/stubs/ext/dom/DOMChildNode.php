<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\DOMChildNode', 'DOMChildNode', \false);
