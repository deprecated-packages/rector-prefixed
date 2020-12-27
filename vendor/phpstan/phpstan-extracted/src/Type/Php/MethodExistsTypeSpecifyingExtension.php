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
use PHPStan\Type\Accessory\HasMethodType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
class MethodExistsTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'method_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        if (!$objectType instanceof \PHPStan\Type\ObjectType) {
            if ((new \PHPStan\Type\StringType())->isSuperTypeOf($objectType)->yes()) {
                return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        $methodNameType = $scope->getType($node->args[1]->value);
        if (!$methodNameType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\Accessory\HasMethodType($methodNameType->getValue())]), $context);
    }
}
