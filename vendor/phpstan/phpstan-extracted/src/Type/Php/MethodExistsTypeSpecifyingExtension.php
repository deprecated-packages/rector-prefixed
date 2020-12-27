<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\Accessory\HasMethodType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
class MethodExistsTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'method_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        if (!$objectType instanceof \PHPStan\Type\ObjectType) {
            if ((new \PHPStan\Type\StringType())->isSuperTypeOf($objectType)->yes()) {
                return new \PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        $methodNameType = $scope->getType($node->args[1]->value);
        if (!$methodNameType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\Accessory\HasMethodType($methodNameType->getValue())]), $context);
    }
}
