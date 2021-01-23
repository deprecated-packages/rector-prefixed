<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Generic\ValueObject\RemoveFuncCallArg;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210123\Webmozart\Assert\Assert;
/**
 * @sponsor Thanks https://twitter.com/afilina & Zenika (CAN) for sponsoring this rule - visit them on https://zenika.ca/en/en
 *
 * @see \Rector\Generic\Tests\Rector\FuncCall\RemoveFuncCallArgRector\RemoveFuncCallArgRectorTest
 */
final class RemoveFuncCallArgRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const REMOVED_FUNCTION_ARGUMENTS = 'removed_function_arguments';
    /**
     * @var RemoveFuncCallArg[]
     */
    private $removedFunctionArguments = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove argument by position by function name', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
remove_last_arg(1, 2);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
remove_last_arg(1);
CODE_SAMPLE
, [self::REMOVED_FUNCTION_ARGUMENTS => [new \Rector\Generic\ValueObject\RemoveFuncCallArg('remove_last_arg', 1)]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->removedFunctionArguments as $removedFunctionArgument) {
            if (!$this->isName($node->name, $removedFunctionArgument->getFunction())) {
                continue;
            }
            foreach (\array_keys($node->args) as $position) {
                if ($removedFunctionArgument->getArgumentPosition() !== $position) {
                    continue;
                }
                unset($node->args[$position]);
            }
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $removedFunctionArguments = $configuration[self::REMOVED_FUNCTION_ARGUMENTS] ?? [];
        \RectorPrefix20210123\Webmozart\Assert\Assert::allIsInstanceOf($removedFunctionArguments, \Rector\Generic\ValueObject\RemoveFuncCallArg::class);
        $this->removedFunctionArguments = $removedFunctionArguments;
    }
}
