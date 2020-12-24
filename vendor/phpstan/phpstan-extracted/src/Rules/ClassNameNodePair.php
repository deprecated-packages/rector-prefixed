<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules;

use _PhpScoper0a6b37af0871\PhpParser\Node;
class ClassNameNodePair
{
    /** @var string */
    private $className;
    /** @var Node */
    private $node;
    public function __construct(string $className, \_PhpScoper0a6b37af0871\PhpParser\Node $node)
    {
        $this->className = $className;
        $this->node = $node;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getNode() : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->node;
    }
}
