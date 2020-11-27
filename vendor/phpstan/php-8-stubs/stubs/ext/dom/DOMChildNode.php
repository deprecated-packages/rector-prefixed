<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\DOMChildNode', 'DOMChildNode', \false);
