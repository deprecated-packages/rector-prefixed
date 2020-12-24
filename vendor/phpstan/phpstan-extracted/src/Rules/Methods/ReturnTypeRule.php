<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Methods;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FunctionReturnTypeCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $reflection = null;
        if ($method->getDeclaringClass()->getNativeReflection()->hasMethod($method->getName())) {
            $reflection = $method->getDeclaringClass()->getNativeReflection()->getMethod($method->getName());
        }
        return $this->returnTypeCheck->checkReturnType($scope, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType(), $node->expr, \sprintf('Method %s::%s() should return %%s but empty return statement found.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() with return type void returns %%s but should not return anything.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() should return %%s but returns %%s.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() should never return but return statement found.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
