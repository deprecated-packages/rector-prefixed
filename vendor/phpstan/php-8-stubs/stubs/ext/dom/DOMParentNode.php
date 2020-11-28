<?php

namespace _PhpScoperabd03f0baf05;

interface DOMParentNode
{
    /** @param DOMNode|string $nodes */
    public function append(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function prepend(...$nodes) : void;
}
\class_alias('_PhpScoperabd03f0baf05\\DOMParentNode', 'DOMParentNode', \false);
