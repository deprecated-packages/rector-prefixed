<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\SwapClassMethodArgumentsRectorTest
 */
final class SwapClassMethodArgumentsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_SWAPS = 'argument_swaps';
    /**
     * @var SwapClassMethodArguments[]
     */
    private $argumentSwaps = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Reorder class method arguments, including their calls', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public static function run($first, $second)
    {
        self::run($first, $second);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public static function run($second, $first)
    {
        self::run($second, $first);
    }
}
CODE_SAMPLE
, [self::ARGUMENT_SWAPS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapClassMethodArguments('SomeClass', 'run', [1, 0])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->argumentSwaps as $argumentSwap) {
            if (!$this->isMethodStaticCallOrClassMethodObjectType($node, $argumentSwap->getClass())) {
                continue;
            }
            $this->refactorArgumentPositions($argumentSwap, $node);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $argumentSwaps = $configuration[self::ARGUMENT_SWAPS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($argumentSwaps, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapClassMethodArguments::class);
        $this->argumentSwaps = $argumentSwaps;
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    private function refactorArgumentPositions(\_PhpScopere8e811afab72\Rector\Generic\ValueObject\SwapClassMethodArguments $swapClassMethodArguments, \_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if (!$this->isMethodStaticCallOrClassMethodName($node, $swapClassMethodArguments->getMethod())) {
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $this->swapParameters($node, $swapClassMethodArguments->getOrder());
        } else {
            $this->swapArguments($node, $swapClassMethodArguments->getOrder());
        }
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    private function isMethodStaticCallOrClassMethodName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $methodName) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
                return \false;
            }
            return $this->isName($node->name, $methodName);
        }
        return $this->isName($node->name, $methodName);
    }
    /**
     * @param array<int, int> $newParameterPositions
     */
    private function swapParameters(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, array $newParameterPositions) : void
    {
        $newArguments = [];
        foreach ($newParameterPositions as $oldPosition => $newPosition) {
            if (!isset($classMethod->params[$oldPosition]) || !isset($classMethod->params[$newPosition])) {
                continue;
            }
            $newArguments[$newPosition] = $classMethod->params[$oldPosition];
        }
        foreach ($newArguments as $newPosition => $argument) {
            $classMethod->params[$newPosition] = $argument;
        }
    }
    /**
     * @param MethodCall|StaticCall $node
     * @param int[] $newArgumentPositions
     */
    private function swapArguments(\_PhpScopere8e811afab72\PhpParser\Node $node, array $newArgumentPositions) : void
    {
        $newArguments = [];
        foreach ($newArgumentPositions as $oldPosition => $newPosition) {
            if (!isset($node->args[$oldPosition]) || !isset($node->args[$newPosition])) {
                continue;
            }
            $newArguments[$newPosition] = $node->args[$oldPosition];
        }
        foreach ($newArguments as $newPosition => $argument) {
            $node->args[$newPosition] = $argument;
        }
    }
}
