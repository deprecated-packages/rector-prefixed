<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\DOMChildNode', 'DOMChildNode', \false);
