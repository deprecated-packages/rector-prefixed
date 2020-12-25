<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\NeverType;
use PHPStan\Type\TypeCombinator;
class ClassExistsFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \in_array($functionReflection->getName(), ['class_exists', 'interface_exists', 'trait_exists'], \true) && isset($node->args[0]) && $context->truthy();
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $argType = $scope->getType($node->args[0]->value);
        $classStringType = new \PHPStan\Type\ClassStringType();
        if (\PHPStan\Type\TypeCombinator::intersect($argType, $classStringType) instanceof \PHPStan\Type\NeverType) {
            if ($argType instanceof \PHPStan\Type\Constant\ConstantStringType) {
                return $this->typeSpecifier->create(new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name\FullyQualified('class_exists'), [new \PhpParser\Node\Arg(new \PhpParser\Node\Scalar\String_(\ltrim($argType->getValue(), '\\')))]), new \PHPStan\Type\Constant\ConstantBooleanType(\true), $context);
            }
            return new \PHPStan\Analyser\SpecifiedTypes();
        }
        return $this->typeSpecifier->create($node->args[0]->value, $classStringType, $context);
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
