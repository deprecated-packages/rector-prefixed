<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
class IsAFunctionTypeSpecifyingExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_a' && isset($node->args[0]) && isset($node->args[1]) && !$context->null();
    }
    public function specifyTypes(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
        }
        $classNameArgExpr = $node->args[1]->value;
        $classNameArgExprType = $scope->getType($classNameArgExpr);
        if ($classNameArgExpr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch && $classNameArgExpr->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name && $classNameArgExpr->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier && \strtolower($classNameArgExpr->name->name) === 'class') {
            $className = $scope->resolveName($classNameArgExpr->class);
            if (\strtolower($classNameArgExpr->class->toString()) === 'static') {
                $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType($className);
            } else {
                $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className);
            }
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($classNameArgExprType->getValue());
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType) {
            $objectType = $classNameArgExprType->getGenericType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($context->true()) {
            $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } else {
            $types = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
        }
        if (isset($node->args[2]) && $context->true()) {
            if (!$scope->getType($node->args[2]->value)->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true))->no()) {
                $types = $types->intersectWith($this->typeSpecifier->create($node->args[0]->value, isset($objectType) ? new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType($objectType) : new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType(), $context));
            }
        }
        return $types;
    }
    public function setTypeSpecifier(\_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
