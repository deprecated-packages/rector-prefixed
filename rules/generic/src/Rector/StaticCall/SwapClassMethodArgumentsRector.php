<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\StaticCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapClassMethodArguments;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\StaticCall\SwapClassMethodArgumentsRector\SwapClassMethodArgumentsRectorTest
 */
final class SwapClassMethodArgumentsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_SWAPS = 'argument_swaps';
    /**
     * @var SwapClassMethodArguments[]
     */
    private $argumentSwaps = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Reorder class method arguments, including their calls', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::ARGUMENT_SWAPS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapClassMethodArguments('SomeClass', 'run', [1, 0])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($argumentSwaps, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapClassMethodArguments::class);
        $this->argumentSwaps = $argumentSwaps;
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    private function refactorArgumentPositions(\_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapClassMethodArguments $swapClassMethodArguments, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if (!$this->isMethodStaticCallOrClassMethodName($node, $swapClassMethodArguments->getMethod())) {
            return;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            $this->swapParameters($node, $swapClassMethodArguments->getOrder());
        } else {
            $this->swapArguments($node, $swapClassMethodArguments->getOrder());
        }
    }
    /**
     * @param StaticCall|MethodCall|ClassMethod $node
     */
    private function isMethodStaticCallOrClassMethodName(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $methodName) : bool
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
            if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
                return \false;
            }
            return $this->isName($node->name, $methodName);
        }
        return $this->isName($node->name, $methodName);
    }
    /**
     * @param array<int, int> $newParameterPositions
     */
    private function swapParameters(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, array $newParameterPositions) : void
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
    private function swapArguments(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $newArgumentPositions) : void
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
