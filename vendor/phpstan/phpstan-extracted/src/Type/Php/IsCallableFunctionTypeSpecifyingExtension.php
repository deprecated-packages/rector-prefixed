<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\CallableType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
class IsCallableFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension */
    private $methodExistsExtension;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension $methodExistsExtension)
    {
        $this->methodExistsExtension = $methodExistsExtension;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_callable' && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $value = $node->args[0]->value;
        $valueType = $scope->getType($value);
        if ($value instanceof \PhpParser\Node\Expr\Array_ && \count($value->items) === 2 && $valueType instanceof \PHPStan\Type\Constant\ConstantArrayType && !$valueType->isCallable()->no()) {
            if ($value->items[0] === null || $value->items[1] === null) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            $functionCall = new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('method_exists'), [new \PhpParser\Node\Arg($value->items[0]->value), new \PhpParser\Node\Arg($value->items[1]->value)]);
            return $this->methodExistsExtension->specifyTypes($functionReflection, $functionCall, $scope, $context);
        }
        return $this->typeSpecifier->create($value, new \PHPStan\Type\CallableType(), $context);
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
