<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node $nameNode, \_PhpScoperb75b35f52b74\PhpParser\Node $parentNode)
    {
        $this->nameNode = $nameNode;
        $this->parentNode = $parentNode;
    }
    /**
     * @return Name|Identifier
     */
    public function getNameNode() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->nameNode;
    }
    public function getParentNode() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->parentNode;
    }
}
