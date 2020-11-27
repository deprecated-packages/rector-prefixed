<?php

namespace _PhpScoperbd5d0c5f7638;

interface DOMParentNode
{
    /** @param DOMNode|string $nodes */
    public function append(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function prepend(...$nodes) : void;
}
\class_alias('_PhpScoperbd5d0c5f7638\\DOMParentNode', 'DOMParentNode', \false);
