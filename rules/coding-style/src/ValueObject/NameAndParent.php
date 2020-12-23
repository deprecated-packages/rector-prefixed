<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node $nameNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $parentNode)
    {
        $this->nameNode = $nameNode;
        $this->parentNode = $parentNode;
    }
    /**
     * @return Name|Identifier
     */
    public function getNameNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->nameNode;
    }
    public function getParentNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->parentNode;
    }
}
