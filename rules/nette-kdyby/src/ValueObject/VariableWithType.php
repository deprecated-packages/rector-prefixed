<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class VariableWithType
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Type
     */
    private $type;
    /**
     * @var Identifier|Name|NullableType|UnionType|null
     */
    private $phpParserTypeNode;
    /**
     * @param Identifier|Name|NullableType|UnionType|null $phpParserTypeNode
     */
    public function __construct(string $name, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $staticType, ?\_PhpScoperb75b35f52b74\PhpParser\Node $phpParserTypeNode)
    {
        $this->name = $name;
        $this->type = $staticType;
        $this->phpParserTypeNode = $phpParserTypeNode;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getPhpParserTypeNode() : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->phpParserTypeNode;
    }
}
