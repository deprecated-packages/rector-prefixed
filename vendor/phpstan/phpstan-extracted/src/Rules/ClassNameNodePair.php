<?php

declare (strict_types=1);
namespace PHPStan\Rules;

use PhpParser\Node;
class ClassNameNodePair
{
    /** @var string */
    private $className;
    /** @var Node */
    private $node;
    public function __construct(string $className, \PhpParser\Node $node)
    {
        $this->className = $className;
        $this->node = $node;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getNode() : \PhpParser\Node
    {
        return $this->node;
    }
}
