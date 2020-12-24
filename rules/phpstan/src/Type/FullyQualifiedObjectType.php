<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStan\Type;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class FullyQualifiedObjectType extends \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType
{
    public function getShortNameType() : \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType
    {
        return new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType($this->getShortName(), $this->getClassName());
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
    public function getShortName() : string
    {
        if (!\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($this->getClassName(), '\\')) {
            return $this->getClassName();
        }
        return (string) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::after($this->getClassName(), '\\', -1);
    }
    public function getShortNameNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Name
    {
        $name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($this->getShortName());
        $name->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::VIRTUAL_NODE, \true);
        return $name;
    }
    public function getUseNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse($name);
        $name->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getFunctionUseNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($this->getClassName());
        $useUse = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse($name, null, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
        $name->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_([$useUse]);
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
