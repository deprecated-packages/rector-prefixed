<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
class CountFunctionTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return !$context->null() && \count($node->args) >= 1 && $functionReflection->getName() === 'count';
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        if (!(new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType()))->isSuperTypeOf($scope->getType($node->args[0]->value))->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType(), $context);
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
