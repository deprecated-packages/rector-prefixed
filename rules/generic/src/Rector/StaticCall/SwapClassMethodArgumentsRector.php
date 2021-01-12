<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Generic\ValueObject\SwapClassMethodArguments;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210112\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\SwapClassMethodArgumentsRectorTest
 */
final class SwapClassMethodArgumentsRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_SWAPS = 'argument_swaps';
    /**
     * @var SwapClassMethodArguments[]
     */
    private $argumentSwaps = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Reorder class method arguments, including their calls', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::ARGUMENT_SWAPS => [new \Rector\Generic\ValueObject\SwapClassMethodArguments('SomeClass', 'run', [1, 0])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
        \RectorPrefix20210112\Webmozart\Assert\Assert::allIsInstanceOf($argumentSwaps, \Rector\Generic\ValueObject\SwapClassMethodArguments::class);
        $this->argumentSwaps = $argumentSwaps;
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    private function refactorArgumentPositions(\Rector\Generic\ValueObject\SwapClassMethodArguments $swapClassMethodArguments, \PhpParser\Node $node) : void
    {
        if (!$this->isMethodStaticCallOrClassMethodName($node, $swapClassMethodArguments->getMethod())) {
            return;
        }
        if ($node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->swapParameters($node, $swapClassMethodArguments->getOrder());
        } else {
            $this->swapArguments($node, $swapClassMethodArguments->getOrder());
        }
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    private function isMethodStaticCallOrClassMethodName(\PhpParser\Node $node, string $methodName) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall) {
            if ($node->name instanceof \PhpParser\Node\Expr) {
                return \false;
            }
            return $this->isName($node->name, $methodName);
        }
        return $this->isName($node->name, $methodName);
    }
    /**
     * @param array<int, int> $newParameterPositions
     */
    private function swapParameters(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $newParameterPositions) : void
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
    private function swapArguments(\PhpParser\Node $node, array $newArgumentPositions) : void
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
