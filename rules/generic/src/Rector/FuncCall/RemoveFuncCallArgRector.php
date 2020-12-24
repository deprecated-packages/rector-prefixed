<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @sponsor Thanks https://twitter.com/afilina & Zenika (CAN) for sponsoring this rule - visit them on https://zenika.ca/en/en
 *
 * @see \Rector\Generic\Tests\Rector\FuncCall\RemoveFuncCallArgRector\RemoveFuncCallArgRectorTest
 */
final class RemoveFuncCallArgRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const REMOVED_FUNCTION_ARGUMENTS = 'removed_function_arguments';
    /**
     * @var RemoveFuncCallArg[]
     */
    private $removedFunctionArguments = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove argument by position by function name', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
remove_last_arg(1, 2);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
remove_last_arg(1);
CODE_SAMPLE
, [self::REMOVED_FUNCTION_ARGUMENTS => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg('remove_last_arg', 1)]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($removedFunctionArguments, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg::class);
        $this->removedFunctionArguments = $removedFunctionArguments;
    }
}
