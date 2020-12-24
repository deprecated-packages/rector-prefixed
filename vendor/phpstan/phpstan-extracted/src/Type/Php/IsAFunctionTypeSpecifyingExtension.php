<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
class IsAFunctionTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_a' && isset($node->args[0]) && isset($node->args[1]) && !$context->null();
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $classNameArgExpr = $node->args[1]->value;
        $classNameArgExprType = $scope->getType($classNameArgExpr);
        if ($classNameArgExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch && $classNameArgExpr->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name && $classNameArgExpr->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier && \strtolower($classNameArgExpr->name->name) === 'class') {
            $className = $scope->resolveName($classNameArgExpr->class);
            if (\strtolower($classNameArgExpr->class->toString()) === 'static') {
                $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType($className);
            } else {
                $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
            }
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classNameArgExprType->getValue());
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($classNameArgExprType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType) {
            $objectType = $classNameArgExprType->getGenericType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } elseif ($context->true()) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType();
            $types = $this->typeSpecifier->create($node->args[0]->value, $objectType, $context);
        } else {
            $types = new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes();
        }
        if (isset($node->args[2]) && $context->true()) {
            if (!$scope->getType($node->args[2]->value)->isSuperTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true))->no()) {
                $types = $types->intersectWith($this->typeSpecifier->create($node->args[0]->value, isset($objectType) ? new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType($objectType) : new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType(), $context));
            }
        }
        return $types;
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
