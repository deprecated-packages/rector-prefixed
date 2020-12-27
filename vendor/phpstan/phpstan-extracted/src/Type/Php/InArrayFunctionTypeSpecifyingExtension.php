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
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\TypeUtils;
class InArrayFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'in_array' && \count($node->args) >= 3 && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $strictNodeType = $scope->getType($node->args[2]->value);
        if (!(new \PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($strictNodeType)->yes()) {
            return new \PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $arrayValueType = $scope->getType($node->args[1]->value)->getIterableValueType();
        if ($context->truthy() || \count(\PHPStan\Type\TypeUtils::getConstantScalars($arrayValueType)) > 0) {
            return $this->typeSpecifier->create($node->args[0]->value, $arrayValueType, $context);
        }
        return new \PHPStan\Analyser\SpecifiedTypes([], []);
    }
}
