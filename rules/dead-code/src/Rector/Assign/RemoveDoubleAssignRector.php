<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeNestingScope\ScopeNestingComparator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Assign\RemoveDoubleAssignRector\RemoveDoubleAssignRectorTest
 */
final class RemoveDoubleAssignRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator)
    {
        $this->scopeNestingComparator = $scopeNestingComparator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify useless double assigns', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$value = 1;
$value = 1;
CODE_SAMPLE
, '$value = 1;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable && !$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            return null;
        }
        $previousStatement = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if (!$previousStatement instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$previousStatement->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$this->areNodesEqual($previousStatement->expr->var, $node->var)) {
            return null;
        }
        if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall || $node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall || $node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if ($this->shouldSkipForDifferentScope($node, $previousStatement)) {
            return null;
        }
        if ($this->isSelfReferencing($node)) {
            return null;
        }
        // no calls on right, could hide e.g. array_pop()|array_shift()
        $this->removeNode($previousStatement);
        return $node;
    }
    private function shouldSkipForDifferentScope(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $expression) : bool
    {
        if (!$this->areInSameClassMethod($assign, $expression)) {
            return \true;
        }
        return !$this->scopeNestingComparator->areScopeNestingEqual($assign, $expression);
    }
    private function isSelfReferencing(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($assign->expr, function (\_PhpScoperb75b35f52b74\PhpParser\Node $subNode) use($assign) : bool {
            return $this->areNodesEqual($assign->var, $subNode);
        });
    }
    private function areInSameClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression $previousExpression) : bool
    {
        return $this->areNodesEqual($assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE), $previousExpression->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE));
    }
}
