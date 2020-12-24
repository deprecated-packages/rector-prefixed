<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStan\Type;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class FullyQualifiedObjectType extends \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType
{
    public function getShortNameType() : \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType
    {
        return new \_PhpScoper0a6b37af0871\Rector\PHPStan\Type\ShortenedObjectType($this->getShortName(), $this->getClassName());
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
    public function getShortName() : string
    {
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($this->getClassName(), '\\')) {
            return $this->getClassName();
        }
        return (string) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($this->getClassName(), '\\', -1);
    }
    public function getShortNameNode() : \_PhpScoper0a6b37af0871\PhpParser\Node\Name
    {
        $name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($this->getShortName());
        $name->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE, \true);
        return $name;
    }
    public function getUseNode() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse($name);
        $name->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getFunctionUseNode() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\UseUse($name, null, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
        $name->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_([$useUse]);
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
