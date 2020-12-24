<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\UseUse;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
final class FullyQualifiedObjectType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType
{
    public function getShortNameType() : \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType($this->getShortName(), $this->getClassName());
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
    public function getShortName() : string
    {
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($this->getClassName(), '\\')) {
            return $this->getClassName();
        }
        return (string) \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::after($this->getClassName(), '\\', -1);
    }
    public function getShortNameNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name
    {
        $name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($this->getShortName());
        $name->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE, \true);
        return $name;
    }
    public function getUseNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\UseUse($name);
        $name->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getFunctionUseNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\UseUse($name, null, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
        $name->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_([$useUse]);
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
