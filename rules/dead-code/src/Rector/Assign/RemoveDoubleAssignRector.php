<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeNestingScope\ScopeNestingComparator;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Assign\RemoveDoubleAssignRector\RemoveDoubleAssignRectorTest
 */
final class RemoveDoubleAssignRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    public function __construct(\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator)
    {
        $this->scopeNestingComparator = $scopeNestingComparator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify useless double assigns', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$node->var instanceof \PhpParser\Node\Expr\Variable && !$node->var instanceof \PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return null;
        }
        $previousStatement = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if (!$previousStatement instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$previousStatement->expr instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$this->areNodesEqual($previousStatement->expr->var, $node->var)) {
            return null;
        }
        if ($node->expr instanceof \PhpParser\Node\Expr\FuncCall || $node->expr instanceof \PhpParser\Node\Expr\StaticCall || $node->expr instanceof \PhpParser\Node\Expr\MethodCall) {
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
    private function shouldSkipForDifferentScope(\PhpParser\Node\Expr\Assign $assign, \PhpParser\Node $anotherNode) : bool
    {
        if (!$this->areInSameClassMethod($assign, $anotherNode)) {
            return \true;
        }
        return !$this->scopeNestingComparator->areScopeNestingEqual($assign, $anotherNode);
    }
    private function isSelfReferencing(\PhpParser\Node\Expr\Assign $assign) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($assign->expr, function (\PhpParser\Node $subNode) use($assign) : bool {
            return $this->areNodesEqual($assign->var, $subNode);
        });
    }
    private function areInSameClassMethod(\PhpParser\Node $node, \PhpParser\Node $previousExpression) : bool
    {
        return $this->areNodesEqual($node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE), $previousExpression->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE));
    }
}
