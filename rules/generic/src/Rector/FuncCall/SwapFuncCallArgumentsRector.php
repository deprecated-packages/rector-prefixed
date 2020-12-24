<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapFuncCallArguments;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\FuncCall\SwapFuncCallArgumentsRector\SwapFuncCallArgumentsRectorTest
 */
final class SwapFuncCallArgumentsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNCTION_ARGUMENT_SWAPS = 'new_argument_positions_by_function_name';
    /**
     * @var SwapFuncCallArguments[]
     */
    private $functionArgumentSwaps = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Swap arguments in function calls', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($one, $two)
    {
        return some_function($one, $two);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($one, $two)
    {
        return some_function($two, $one);
    }
}
CODE_SAMPLE
, [self::FUNCTION_ARGUMENT_SWAPS => [new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapFuncCallArguments('some_function', [1, 0])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        foreach ($this->functionArgumentSwaps as $functionArgumentSwap) {
            if (!$this->isName($node, $functionArgumentSwap->getFunction())) {
                continue;
            }
            $newArguments = [];
            foreach ($functionArgumentSwap->getOrder() as $oldPosition => $newPosition) {
                if (!isset($node->args[$oldPosition]) || !isset($node->args[$newPosition])) {
                    continue;
                }
                $newArguments[$newPosition] = $node->args[$oldPosition];
            }
            foreach ($newArguments as $newPosition => $argument) {
                $node->args[$newPosition] = $argument;
            }
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $functionArgumentSwaps = $configuration[self::FUNCTION_ARGUMENT_SWAPS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($functionArgumentSwaps, \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\SwapFuncCallArguments::class);
        $this->functionArgumentSwaps = $functionArgumentSwaps;
    }
}
