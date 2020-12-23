<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\PostInc;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\For_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\PostInc\PostIncDecToPreIncDecRector\PostIncDecToPreIncDecRectorTest
 */
final class PostIncDecToPreIncDecRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ++$value or --$value  instead of `$value++` or `$value--`', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec::class];
    }
    /**
     * @param PostInc|PostDec $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($this->isAnExpression($parentNode)) {
            return $this->processPrePost($node);
        }
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch && $this->areNodesEqual($parentNode->dim, $node)) {
            return $this->processPreArray($node, $parentNode);
        }
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\For_ && \count((array) $parentNode->loop) === 1 && $this->areNodesEqual($parentNode->loop[0], $node)) {
            return $this->processPreFor($node, $parentNode);
        }
        return null;
    }
    private function isAnExpression(?\_PhpScoper0a2ac50786fa\PhpParser\Node $node = null) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
            return \false;
        }
        return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPrePost(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc($node->var);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec($node->var);
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPreArray(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $parentOfArrayDimFetch = $arrayDimFetch->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
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
    private function processPreFor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\For_ $for) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $for->loop = [$this->processPrePost($node)];
        return $for->loop[0];
    }
}
