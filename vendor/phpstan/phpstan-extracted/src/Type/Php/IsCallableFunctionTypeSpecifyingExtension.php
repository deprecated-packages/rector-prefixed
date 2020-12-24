<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\CallableType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension;
class IsCallableFunctionTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension */
    private $methodExistsExtension;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension $methodExistsExtension)
    {
        $this->methodExistsExtension = $methodExistsExtension;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_callable' && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $value = $node->args[0]->value;
        $valueType = $scope->getType($value);
        if ($value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ && \count($value->items) === 2 && $valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType && !$valueType->isCallable()->no()) {
            if ($value->items[0] === null || $value->items[1] === null) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            $functionCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('method_exists'), [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($value->items[0]->value), new \_PhpScopere8e811afab72\PhpParser\Node\Arg($value->items[1]->value)]);
            return $this->methodExistsExtension->specifyTypes($functionReflection, $functionCall, $scope, $context);
        }
        return $this->typeSpecifier->create($value, new \_PhpScopere8e811afab72\PHPStan\Type\CallableType(), $context);
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
