<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasedObjectType extends \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType
{
    /**
     * @var string
     */
    private $fullyQualifiedClass;
    public function __construct(string $alias, string $fullyQualifiedClass)
    {
        parent::__construct($alias);
        $this->fullyQualifiedClass = $fullyQualifiedClass;
    }
    public function getFullyQualifiedClass() : string
    {
        return $this->fullyQualifiedClass;
    }
    public function getUseNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($this->fullyQualifiedClass);
        $useUse = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse($name, $this->getClassName());
        $name->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getShortName() : string
    {
        return $this->getClassName();
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
}
