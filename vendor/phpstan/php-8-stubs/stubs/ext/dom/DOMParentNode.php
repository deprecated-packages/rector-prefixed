<?php

namespace _PhpScoper26e51eeacccf;

interface DOMParentNode
{
    /** @param DOMNode|string $nodes */
    public function append(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function prepend(...$nodes) : void;
}
\class_alias('_PhpScoper26e51eeacccf\\DOMParentNode', 'DOMParentNode', \false);
