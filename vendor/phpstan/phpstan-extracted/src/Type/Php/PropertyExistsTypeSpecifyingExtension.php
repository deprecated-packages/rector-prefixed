<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\HasPropertyType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
class PropertyExistsTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'property_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        $propertyNameType = $scope->getType($node->args[1]->value);
        if (!$propertyNameType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $objectType = $scope->getType($node->args[0]->value);
        if ($objectType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes([], []);
        } elseif ((new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($objectType)->yes()) {
            $propertyNode = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($node->args[0]->value, new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($propertyNameType->getValue()));
        } else {
            return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($propertyNode, $scope);
        if ($propertyReflection !== null) {
            if (!$propertyReflection->isNative()) {
                return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType([new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\HasPropertyType($propertyNameType->getValue())]), $context);
    }
}
