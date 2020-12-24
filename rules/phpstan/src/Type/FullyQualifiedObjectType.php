<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStan\Type;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FullyQualifiedObjectType extends \_PhpScopere8e811afab72\PHPStan\Type\ObjectType
{
    public function getShortNameType() : \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType
    {
        return new \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType($this->getShortName(), $this->getClassName());
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
    public function getShortName() : string
    {
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($this->getClassName(), '\\')) {
            return $this->getClassName();
        }
        return (string) \_PhpScopere8e811afab72\Nette\Utils\Strings::after($this->getClassName(), '\\', -1);
    }
    public function getShortNameNode() : \_PhpScopere8e811afab72\PhpParser\Node\Name
    {
        $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($this->getShortName());
        $name->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE, \true);
        return $name;
    }
    public function getUseNode() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse($name);
        $name->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getFunctionUseNode() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScopere8e811afab72\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse($name, null, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
        $name->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getShortNameLowered() : string
    {
        return \strtolower($this->getShortName());
    }
    public function getClassNameLowered() : string
    {
        return \strtolower($this->getClassName());
    }
}
