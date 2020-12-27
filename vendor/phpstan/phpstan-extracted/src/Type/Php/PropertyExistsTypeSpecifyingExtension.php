<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectWithoutClassType;
class PropertyExistsTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'property_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $propertyNameType = $scope->getType($node->args[1]->value);
        if (!$propertyNameType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $objectType = $scope->getType($node->args[0]->value);
        if ($objectType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Analyser\SpecifiedTypes([], []);
        } elseif ((new \PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($objectType)->yes()) {
            $propertyNode = new \PhpParser\Node\Expr\PropertyFetch($node->args[0]->value, new \PhpParser\Node\Identifier($propertyNameType->getValue()));
        } else {
            return new \PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($propertyNode, $scope);
        if ($propertyReflection !== null) {
            if (!$propertyReflection->isNative()) {
                return new \PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\Accessory\HasPropertyType($propertyNameType->getValue())]), $context);
    }
}
