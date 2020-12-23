<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\HasMethodType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
class MethodExistsTypeSpecifyingExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'method_exists' && $context->truthy() && \count($node->args) >= 2;
    }
    public function specifyTypes(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        if (!$objectType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
            if ((new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType())->isSuperTypeOf($objectType)->yes()) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
            }
        }
        $methodNameType = $scope->getType($node->args[1]->value);
        if (!$methodNameType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\HasMethodType($methodNameType->getValue())]), $context);
    }
}
