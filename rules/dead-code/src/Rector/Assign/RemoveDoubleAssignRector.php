<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Rector\Assign;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeNestingScope\ScopeNestingComparator;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Assign\RemoveDoubleAssignRector\RemoveDoubleAssignRectorTest
 */
final class RemoveDoubleAssignRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator)
    {
        $this->scopeNestingComparator = $scopeNestingComparator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify useless double assigns', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable && !$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
            return null;
        }
        $previousStatement = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT);
        if (!$previousStatement instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$previousStatement->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$this->areNodesEqual($previousStatement->expr->var, $node->var)) {
            return null;
        }
        if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall || $node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall || $node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
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
    private function shouldSkipForDifferentScope(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $expression) : bool
    {
        if (!$this->areInSameClassMethod($assign, $expression)) {
            return \true;
        }
        return !$this->scopeNestingComparator->areScopeNestingEqual($assign, $expression);
    }
    private function isSelfReferencing(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($assign->expr, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $subNode) use($assign) : bool {
            return $this->areNodesEqual($assign->var, $subNode);
        });
    }
    private function areInSameClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression $previousExpression) : bool
    {
        return $this->areNodesEqual($assign->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE), $previousExpression->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE));
    }
}
