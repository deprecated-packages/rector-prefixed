<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\CallableType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\FunctionTypeSpecifyingExtension;
class IsCallableFunctionTypeSpecifyingExtension implements \PHPStan\Type\FunctionTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension */
    private $methodExistsExtension;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension $methodExistsExtension)
    {
        $this->methodExistsExtension = $methodExistsExtension;
    }
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_callable' && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $value = $node->args[0]->value;
        $valueType = $scope->getType($value);
        if ($value instanceof \PhpParser\Node\Expr\Array_ && \count($value->items) === 2 && $valueType instanceof \PHPStan\Type\Constant\ConstantArrayType && !$valueType->isCallable()->no()) {
            if ($value->items[0] === null || $value->items[1] === null) {
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
            }
            $functionCall = new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name('method_exists'), [new \PhpParser\Node\Arg($value->items[0]->value), new \PhpParser\Node\Arg($value->items[1]->value)]);
            return $this->methodExistsExtension->specifyTypes($functionReflection, $functionCall, $scope, $context);
        }
        return $this->typeSpecifier->create($value, new \PHPStan\Type\CallableType(), $context);
    }
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
