<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\TypeUtils;
class InArrayFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'in_array' && \count($node->args) >= 3 && !$context->null();
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        $strictNodeType = $scope->getType($node->args[2]->value);
        if (!(new \PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($strictNodeType)->yes()) {
            return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $arrayValueType = $scope->getType($node->args[1]->value)->getIterableValueType();
        if ($context->truthy() || \count(\PHPStan\Type\TypeUtils::getConstantScalars($arrayValueType)) > 0) {
            return $this->typeSpecifier->create($node->args[0]->value, $arrayValueType, $context);
        }
        return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
    }
}
