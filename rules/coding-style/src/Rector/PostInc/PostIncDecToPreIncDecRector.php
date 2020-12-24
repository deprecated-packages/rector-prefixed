<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\PostInc;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\PostInc\PostIncDecToPreIncDecRector\PostIncDecToPreIncDecRectorTest
 */
final class PostIncDecToPreIncDecRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ++$value or --$value  instead of `$value++` or `$value--`', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec::class];
    }
    /**
     * @param PostInc|PostDec $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($this->isAnExpression($parentNode)) {
            return $this->processPrePost($node);
        }
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch && $this->areNodesEqual($parentNode->dim, $node)) {
            return $this->processPreArray($node, $parentNode);
        }
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_ && \count((array) $parentNode->loop) === 1 && $this->areNodesEqual($parentNode->loop[0], $node)) {
            return $this->processPreFor($node, $parentNode);
        }
        return null;
    }
    private function isAnExpression(?\_PhpScoperb75b35f52b74\PhpParser\Node $node = null) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node) {
            return \false;
        }
        return $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPrePost(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc($node->var);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec($node->var);
    }
    /**
     * @param PostInc|PostDec $node
     */
    private function processPreArray(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $parentOfArrayDimFetch = $arrayDimFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
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
    private function processPreFor(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_ $for) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        $for->loop = [$this->processPrePost($node)];
        return $for->loop[0];
    }
}
