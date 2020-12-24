<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Polyfill\Rector\If_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Polyfill\FeatureSupport\FunctionSupportResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Polyfill\Tests\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector\UnwrapFutureCompatibleIfFunctionExistsRectorTest
 */
final class UnwrapFutureCompatibleIfFunctionExistsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var FunctionSupportResolver
     */
    private $functionSupportResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Polyfill\FeatureSupport\FunctionSupportResolver $functionSupportResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->functionSupportResolver = $functionSupportResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove functions exists if with else for always existing', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        // session locking trough other addons
        if (function_exists('session_abort')) {
            session_abort();
        } else {
            session_write_close();
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        // session locking trough other addons
        session_abort();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $match = $this->ifManipulator->isIfOrIfElseWithFunctionCondition($node, 'function_exists');
        if (!$match) {
            return null;
        }
        /** @var FuncCall $funcCall */
        $funcCall = $node->cond;
        $functionToExistName = $this->getValue($funcCall->args[0]->value);
        if (!\is_string($functionToExistName)) {
            return null;
        }
        if (!$this->functionSupportResolver->isFunctionSupported($functionToExistName)) {
            return null;
        }
        $this->unwrapStmts($node->stmts, $node);
        $this->removeNode($node);
        return null;
    }
}
