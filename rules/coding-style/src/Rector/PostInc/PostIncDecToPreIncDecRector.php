<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\PostInc;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\For_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\PostInc\PostIncDecToPreIncDecRector\PostIncDecToPreIncDecRectorTest
 */
final class PostIncDecToPreIncDecRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ++$value or --$value  instead of `$value++` or `$value--`', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value = 1)
    {
        $value++; echo $value;
        $value--; echo $value;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value = 1)
    {
        ++$value; echo $value;
        --$value; echo $value;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec::class];
    }
    /**
     * @param PostInc|PostDec $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($this->isAnExpression($parentNode)) {
            return $this->processPrePost($node);
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch && $this->areNodesEqual($parentNode->dim, $node)) {
            return $this->processPreArray($node, $parentNode);
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\For_ && \count((array) $parentNode->loop) === 1 && $this->areNodesEqual($parentNode->loop[0], $node)) {
            return $this->processPreFor($node, $parentNode);
        }
        return null;
    }
    private function isAnExpression(?\_PhpScopere8e811afab72\PhpParser\Node $node = null) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
            return \false;
        }
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPrePost(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc($node->var);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec($node->var);
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPreArray(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $parentOfArrayDimFetch = $arrayDimFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$this->isAnExpression($parentOfArrayDimFetch)) {
            return null;
        }
        $arrayDimFetch->dim = $node->var;
        $this->addNodeAfterNode($this->processPrePost($node), $arrayDimFetch);
        return $arrayDimFetch->dim;
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPreFor(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\For_ $for) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $for->loop = [$this->processPrePost($node)];
        return $for->loop[0];
    }
}
