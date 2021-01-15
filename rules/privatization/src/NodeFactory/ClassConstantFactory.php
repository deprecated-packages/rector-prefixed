<?php

declare (strict_types=1);
namespace Rector\Privatization\NodeFactory;

use PhpParser\Node\Const_;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\Property;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Privatization\Naming\ConstantNaming;
final class ClassConstantFactory
{
    /**
     * @var ConstantNaming
     */
    private $constantNaming;
    public function __construct(\Rector\Privatization\Naming\ConstantNaming $constantNaming)
    {
        $this->constantNaming = $constantNaming;
    }
    public function createFromProperty(\PhpParser\Node\Stmt\Property $property) : \PhpParser\Node\Stmt\ClassConst
    {
        $propertyProperty = $property->props[0];
        $constantName = $this->constantNaming->createFromProperty($propertyProperty);
        /** @var Expr $defaultValue */
        $defaultValue = $propertyProperty->default;
        $const = new \PhpParser\Node\Const_($constantName, $defaultValue);
        $classConst = new \PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags = $property->flags & ~\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC;
        $classConst->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO));
        return $classConst;
    }
}
