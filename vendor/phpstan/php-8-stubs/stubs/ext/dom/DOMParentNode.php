<?php

namespace _PhpScopera143bcca66cb;

interface DOMParentNode
{
    /** @param DOMNode|string $nodes */
    public function append(...$nodes) : void;
    /** @param DOMNode|string $nodes */
    public function prepend(...$nodes) : void;
}
\class_alias('_PhpScopera143bcca66cb\\DOMParentNode', 'DOMParentNode', \false);
