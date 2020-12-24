<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
class ClassNameNodePair
{
    /** @var string */
    private $className;
    /** @var Node */
    private $node;
    public function __construct(string $className, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node)
    {
        $this->className = $className;
        $this->node = $node;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->node;
    }
}
