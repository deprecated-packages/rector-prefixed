<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class CallToNonExistentFunctionRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var bool */
    private $checkFunctionNameCase;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkFunctionNameCase)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return [];
        }
        if (!$this->reflectionProvider->hasFunction($node->name, $scope)) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s not found.', (string) $node->name))->discoveringSymbolsTip()->build()];
        }
        $function = $this->reflectionProvider->getFunction($node->name, $scope);
        $name = (string) $node->name;
        if ($this->checkFunctionNameCase) {
            /** @var string $calledFunctionName */
            $calledFunctionName = $this->reflectionProvider->resolveFunctionName($node->name, $scope);
            if (\strtolower($function->getName()) === \strtolower($calledFunctionName) && $function->getName() !== $calledFunctionName) {
                return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function %s() with incorrect case: %s', $function->getName(), $name))->build()];
            }
        }
        return [];
    }
}
