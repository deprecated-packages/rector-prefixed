<?php

declare(strict_types=1);

namespace Rector\DeadCode\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Stmt\If_;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\ConditionEvaluator;
use Rector\DeadCode\ConditionResolver;
use Rector\DeadCode\Contract\ConditionInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://www.php.net/manual/en/function.version-compare.php
 *
 * @see \Rector\Tests\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector\UnwrapFutureCompatibleIfPhpVersionRectorTest
 */
final class UnwrapFutureCompatibleIfPhpVersionRector extends AbstractRector
{
    /**
     * @var ConditionEvaluator
     */
    private $conditionEvaluator;

    /**
     * @var ConditionResolver
     */
    private $conditionResolver;

    public function __construct(ConditionEvaluator $conditionEvaluator, ConditionResolver $conditionResolver)
    {
        $this->conditionEvaluator = $conditionEvaluator;
        $this->conditionResolver = $conditionResolver;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove php version checks if they are passed',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
// current PHP: 7.2
if (version_compare(PHP_VERSION, '7.2', '<')) {
    return 'is PHP 7.1-';
} else {
    return 'is PHP 7.2+';
}
CODE_SAMPLE
,
                    <<<'CODE_SAMPLE'
// current PHP: 7.2
return 'is PHP 7.2+';
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [If_::class];
    }

    /**
     * @param If_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ((bool) $node->elseifs) {
            return null;
        }

        $condition = $this->conditionResolver->resolveFromExpr($node->cond);
        if (! $condition instanceof ConditionInterface) {
            return null;
        }

        $result = $this->conditionEvaluator->evaluate($condition);
        if ($result === null) {
            return null;
        }

        // if is skipped
        if ($result) {
            $this->refactorIsMatch($node);
        } else {
            $this->refactorIsNotMatch($node);
        }

        return $node;
    }

    /**
     * @return void
     */
    private function refactorIsMatch(If_ $if)
    {
        if ((bool) $if->elseifs) {
            return;
        }

        $this->unwrapStmts($if->stmts, $if);

        $this->removeNode($if);
    }

    /**
     * @return void
     */
    private function refactorIsNotMatch(If_ $if)
    {
        // no else → just remove the node
        if ($if->else === null) {
            $this->removeNode($if);
            return;
        }

        // else is always used
        $this->unwrapStmts($if->else->stmts, $if);

        $this->removeNode($if);
    }
}
