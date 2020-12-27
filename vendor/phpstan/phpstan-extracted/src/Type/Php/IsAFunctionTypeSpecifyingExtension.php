<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StaticType;
class IsAFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_a' && isset($node->args[0]) && isset($node->args[1]) && !$context->null();
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $classNameArgExpr = $node->args[1]->value;
        $classNameArgExprType = $scope->getType($classNameArgExpr);
        if ($classNameArgExpr instanceof \PhpParser\Node\Expr\ClassConstFetch && $classNameArgExpr->class instanceof \PhpParser\Node\Name && $classNameArgExpr->name instanceof \PhpParser\Node\Identifier && \strtolower($classNameArgExpr->name->name) === 'class') {
            $className = $scope->resolveName($classNameArgExpr->class);
            if (\strtolower($classNameArgExpr->class->toString()) === 'static') {
                $objectType = new \PHPStan\Type\StaticType($className);
            } else {
                $objectType = new \PHPStan\Type\ObjectType($className);
            }
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $objectType = new \PHPStan\Type\ObjectType($classNameArgExprType->getValue());
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \PHPStan\Type\Generic\GenericClassStringType) {
            $objectType = $classNameArgExprType->getGenericType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($context->true()) {
            $objectType = new \PHPStan\Type\ObjectWithoutClassType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } else {
            $types = new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes();
        }
        if (isset($node->args[2]) && $context->true()) {
            if (!$scope->getType($node->args[2]->value)->isSuperTypeOf(new \PHPStan\Type\Constant\ConstantBooleanType(\true))->no()) {
                $types = $types->intersectWith($this->typeSpecifier->create($node->args[0]->value, isset($objectType) ? new \PHPStan\Type\Generic\GenericClassStringType($objectType) : new \PHPStan\Type\ClassStringType(), $context));
            }
        }
        return $types;
    }
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
