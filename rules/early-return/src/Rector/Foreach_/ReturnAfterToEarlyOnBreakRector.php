<?php

declare (strict_types=1);
namespace Rector\EarlyReturn\Rector\Foreach_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\Foreach_\ReturnAfterToEarlyOnBreakRector\ReturnAfterToEarlyOnBreakRectorTest
 */
final class ReturnAfterToEarlyOnBreakRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change return after foreach to early return in foreach on break', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(array $pathConstants, string $allowedPath)
    {
        $pathOK = false;

        foreach ($pathConstants as $allowedPath) {
            if ($dirPath == $allowedPath) {
                $pathOK = true;
                break;
            }
        }

        return $pathOK;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(array $pathConstants, string $allowedPath)
    {
        foreach ($pathConstants as $allowedPath) {
            if ($dirPath == $allowedPath) {
                return true;
            }
        }

        return false;
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
        return [\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var Break_[] $breaks */
        $breaks = $this->betterNodeFinder->findInstanceOf($node->stmts, \PhpParser\Node\Stmt\Break_::class);
        if (\count($breaks) !== 1) {
            return null;
        }
        $beforeBreak = $breaks[0]->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if (!$beforeBreak instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $assign = $beforeBreak->expr;
        if (!$assign instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        $nextForeach = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextForeach instanceof \PhpParser\Node\Stmt\Return_) {
            return null;
        }
        $assignVariable = $assign->var;
        $variablePrevious = $this->betterNodeFinder->findFirstPreviousOfNode($node, function (\PhpParser\Node $node) use($assignVariable) : bool {
            $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parent instanceof \PhpParser\Node\Expr\Assign) {
                return \false;
            }
            return $this->areNodesEqual($node, $assignVariable);
        });
        if (!$variablePrevious instanceof \PhpParser\Node) {
            return null;
        }
        if (!$this->areNodesEqual($nextForeach->expr, $variablePrevious)) {
            return null;
        }
        // ensure the variable only used once in foreach
        $usedVariable = $this->betterNodeFinder->find($node->stmts, function (\PhpParser\Node $node) use($assignVariable) : bool {
            return $this->areNodesEqual($node, $assignVariable);
        });
        if (\count($usedVariable) > 1) {
            return null;
        }
        $this->removeNode($beforeBreak);
        $this->addNodeBeforeNode(new \PhpParser\Node\Stmt\Return_($assign->expr), $breaks[0]);
        $this->removeNode($breaks[0]);
        /** @var Assign $assignPreviousVariable */
        $assignPreviousVariable = $variablePrevious->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        $nextForeach->expr = $assignPreviousVariable->expr;
        $this->removeNode($assignPreviousVariable);
        return $node;
    }
}
