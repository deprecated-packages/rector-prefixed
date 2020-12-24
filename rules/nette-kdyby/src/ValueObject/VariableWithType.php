<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
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
    public function __construct(string $name, \_PhpScopere8e811afab72\PHPStan\Type\Type $staticType, ?\_PhpScopere8e811afab72\PhpParser\Node $phpParserTypeNode)
    {
        $this->name = $name;
        $this->type = $staticType;
        $this->phpParserTypeNode = $phpParserTypeNode;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @return Identifier|Name|NullableType|UnionType|null
     */
    public function getPhpParserTypeNode() : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->phpParserTypeNode;
    }
}
