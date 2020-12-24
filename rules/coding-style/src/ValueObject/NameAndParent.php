<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node $nameNode, \_PhpScopere8e811afab72\PhpParser\Node $parentNode)
    {
        $this->nameNode = $nameNode;
        $this->parentNode = $parentNode;
    }
    /**
     * @return Name|Identifier
     */
    public function getNameNode() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->nameNode;
    }
    public function getParentNode() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->parentNode;
    }
}
