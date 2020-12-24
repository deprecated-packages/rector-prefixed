<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType;
class IsAFunctionTypeSpecifyingExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_a' && isset($node->args[0]) && isset($node->args[1]) && !$context->null();
    }
    public function specifyTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        $classNameArgExpr = $node->args[1]->value;
        $classNameArgExprType = $scope->getType($classNameArgExpr);
        if ($classNameArgExpr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch && $classNameArgExpr->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name && $classNameArgExpr->name instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier && \strtolower($classNameArgExpr->name->name) === 'class') {
            $className = $scope->resolveName($classNameArgExpr->class);
            if (\strtolower($classNameArgExpr->class->toString()) === 'static') {
                $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType($className);
            } else {
                $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($className);
            }
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($classNameArgExprType->getValue());
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType) {
            $objectType = $classNameArgExprType->getGenericType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($context->true()) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } else {
            $types = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes();
        }
        if (isset($node->args[2]) && $context->true()) {
            if (!$scope->getType($node->args[2]->value)->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\true))->no()) {
                $types = $types->intersectWith($this->typeSpecifier->create($node->args[0]->value, isset($objectType) ? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType($objectType) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType(), $context));
            }
        }
        return $types;
    }
    public function setTypeSpecifier(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
