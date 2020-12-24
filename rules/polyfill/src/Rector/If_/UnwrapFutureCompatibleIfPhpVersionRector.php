<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Polyfill\Rector\If_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Polyfill\ConditionEvaluator;
use _PhpScoper0a6b37af0871\Rector\Polyfill\ConditionResolver;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/function.version-compare.php
 *
 * @see \Rector\Polyfill\Tests\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector\UnwrapFutureCompatibleIfPhpVersionRectorTest
 */
final class UnwrapFutureCompatibleIfPhpVersionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ConditionEvaluator
     */
    private $conditionEvaluator;
    /**
     * @var ConditionResolver
     */
    private $conditionResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Polyfill\ConditionEvaluator $conditionEvaluator, \_PhpScoper0a6b37af0871\Rector\Polyfill\ConditionResolver $conditionResolver)
    {
        $this->conditionEvaluator = $conditionEvaluator;
        $this->conditionResolver = $conditionResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove php version checks if they are passed', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
// current PHP: 7.2
if (version_compare(PHP_VERSION, '7.2', '<')) {
    return 'is PHP 7.1-';
} else {
    return 'is PHP 7.2+';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
// current PHP: 7.2
return 'is PHP 7.2+';
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ((bool) $node->elseifs) {
            return null;
        }
        $condition = $this->conditionResolver->resolveFromExpr($node->cond);
        if ($condition === null) {
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
    private function refactorIsMatch(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $if) : void
    {
        if ((bool) $if->elseifs) {
            return;
        }
        $this->unwrapStmts($if->stmts, $if);
        $this->removeNode($if);
    }
    private function refactorIsNotMatch(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $if) : void
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
