<?php

namespace _PhpScoper006a73f0e455;

interface DOMParentNode
{
    /** @param DOMNode|string $nodes */
    public function append(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function prepend(...$nodes) : void;
}
\class_alias('_PhpScoper006a73f0e455\\DOMParentNode', 'DOMParentNode', \false);
