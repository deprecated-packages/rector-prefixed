<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectWithoutClassType;
class PropertyExistsTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'property_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        $propertyNameType = $scope->getType($node->args[1]->value);
        if (!$propertyNameType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $objectType = $scope->getType($node->args[0]->value);
        if ($objectType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
        } elseif ((new \PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($objectType)->yes()) {
            $propertyNode = new \PhpParser\Node\Expr\PropertyFetch($node->args[0]->value, new \PhpParser\Node\Identifier($propertyNameType->getValue()));
        } else {
            return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($propertyNode, $scope);
        if ($propertyReflection !== null) {
            if (!$propertyReflection->isNative()) {
                return new \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\Accessory\HasPropertyType($propertyNameType->getValue())]), $context);
    }
}
