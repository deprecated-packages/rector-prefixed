<?php

declare (strict_types=1);
namespace Rector\CodingStyle\ValueObject;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
final class NameAndParent
{
    /**
     * @var \PhpParser\Node
     */
    private $nameNode;
    /**
     * @var \PhpParser\Node
     */
    private $parentNode;
    public function __construct(\PhpParser\Node $nameNode, \PhpParser\Node $parentNode)
    {
        $this->nameNode = $nameNode;
        $this->parentNode = $parentNode;
    }
    /**
     * @return Name|Identifier
     */
    public function getNameNode() : \PhpParser\Node
    {
        return $this->nameNode;
    }
    public function getParentNode() : \PhpParser\Node
    {
        return $this->parentNode;
    }
}
