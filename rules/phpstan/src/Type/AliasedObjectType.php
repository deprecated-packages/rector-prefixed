<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStan\Type;

use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasedObjectType extends \_PhpScopere8e811afab72\PHPStan\Type\ObjectType
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
    public function getUseNode() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($this->fullyQualifiedClass);
        $useUse = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse($name, $this->getClassName());
        $name->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getShortName() : string
    {
        return $this->getClassName();
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
}
