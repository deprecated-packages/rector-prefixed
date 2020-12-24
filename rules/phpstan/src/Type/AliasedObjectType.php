<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStan\Type;

use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class AliasedObjectType extends \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType
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
    public function getUseNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_
    {
        $name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($this->fullyQualifiedClass);
        $useUse = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse($name, $this->getClassName());
        $name->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $useUse);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_([$useUse]);
    }
    public function getShortName() : string
    {
        return $this->getClassName();
    }
    /**
     * @param AliasedObjectType|FullyQualifiedObjectType $comparedObjectType
     */
    public function areShortNamesEqual(\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $comparedObjectType) : bool
    {
        return $this->getShortName() === $comparedObjectType->getShortName();
    }
}
