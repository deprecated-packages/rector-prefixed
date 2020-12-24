<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
final class NameAndParent
{
    /**
     * @var Node
     */
    private $parentNode;
    /**
     * @var Name|Identifier
     */
    private $nameNode;
    /**
     * @param Name|Identifier $nameNode
     */
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $nameNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $parentNode)
    {
        $this->nameNode = $nameNode;
        $this->parentNode = $parentNode;
    }
    /**
     * @return Name|Identifier
     */
    public function getNameNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->nameNode;
    }
    public function getParentNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->parentNode;
    }
}
