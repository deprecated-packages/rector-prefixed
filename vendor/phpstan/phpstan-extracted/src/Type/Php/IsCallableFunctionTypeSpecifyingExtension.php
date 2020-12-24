<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\CallableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension;
class IsCallableFunctionTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension */
    private $methodExistsExtension;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Php\MethodExistsTypeSpecifyingExtension $methodExistsExtension)
    {
        $this->methodExistsExtension = $methodExistsExtension;
    }
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_callable' && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $value = $node->args[0]->value;
        $valueType = $scope->getType($value);
        if ($value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ && \count($value->items) === 2 && $valueType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType && !$valueType->isCallable()->no()) {
            if ($value->items[0] === null || $value->items[1] === null) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            $functionCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('method_exists'), [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($value->items[0]->value), new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($value->items[1]->value)]);
            return $this->methodExistsExtension->specifyTypes($functionReflection, $functionCall, $scope, $context);
        }
        return $this->typeSpecifier->create($value, new \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType(), $context);
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
