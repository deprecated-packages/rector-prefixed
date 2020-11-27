<?php

namespace _PhpScoper88fe6e0ad041;

interface DOMParentNode
{
    /** @param DOMNode|string $nodes */
    public function append(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function prepend(...$nodes) : void;
}
\class_alias('_PhpScoper88fe6e0ad041\\DOMParentNode', 'DOMParentNode', \false);
