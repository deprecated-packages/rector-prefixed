<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\HasPropertyType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
class PropertyExistsTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'property_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        $propertyNameType = $scope->getType($node->args[1]->value);
        if (!$propertyNameType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $objectType = $scope->getType($node->args[0]->value);
        if ($objectType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes([], []);
        } elseif ((new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($objectType)->yes()) {
            $propertyNode = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch($node->args[0]->value, new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($propertyNameType->getValue()));
        } else {
            return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($propertyNode, $scope);
        if ($propertyReflection !== null) {
            if (!$propertyReflection->isNative()) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\HasPropertyType($propertyNameType->getValue())]), $context);
    }
}
