<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

use _PhpScoperb75b35f52b74\PhpParser\Node;
class ClassNameNodePair
{
    /** @var string */
    private $className;
    /** @var Node */
    private $node;
    public function __construct(string $className, \_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        $this->className = $className;
        $this->node = $node;
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function getNode() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->node;
    }
}
