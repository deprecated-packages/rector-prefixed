<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\HasPropertyType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
class PropertyExistsTypeSpecifyingExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function setTypeSpecifier(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'property_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes
    {
        $propertyNameType = $scope->getType($node->args[1]->value);
        if (!$propertyNameType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $objectType = $scope->getType($node->args[0]->value);
        if ($objectType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
        } elseif ((new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($objectType)->yes()) {
            $propertyNode = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch($node->args[0]->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($propertyNameType->getValue()));
        } else {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($propertyNode, $scope);
        if ($propertyReflection !== null) {
            if (!$propertyReflection->isNative()) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\HasPropertyType($propertyNameType->getValue())]), $context);
    }
}
