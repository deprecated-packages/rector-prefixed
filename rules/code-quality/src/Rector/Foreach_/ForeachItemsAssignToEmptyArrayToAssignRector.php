<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\Foreach_;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Foreach_;
use Rector\CodeQuality\NodeAnalyzer\ForeachNodeAnalyzer;
use Rector\Core\NodeFinder\NodeUsageFinder;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector\ForeachItemsAssignToEmptyArrayToAssignRectorTest
 */
final class ForeachItemsAssignToEmptyArrayToAssignRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var NodeUsageFinder
     */
    private $nodeUsageFinder;
    /**
     * @var ForeachNodeAnalyzer
     */
    private $foreachNodeAnalyzer;
    public function __construct(\Rector\Core\NodeFinder\NodeUsageFinder $nodeUsageFinder, \Rector\CodeQuality\NodeAnalyzer\ForeachNodeAnalyzer $foreachNodeAnalyzer)
    {
        $this->nodeUsageFinder = $nodeUsageFinder;
        $this->foreachNodeAnalyzer = $foreachNodeAnalyzer;
    }
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change foreach() items assign to empty array to direct assign', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $collectedItems = [];

        foreach ($items as $item) {
             $collectedItems[] = $item;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($items)
    {
        $collectedItems = [];

        $collectedItems = $items;
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
        $assignVariable = $this->foreachNodeAnalyzer->matchAssignItemsOnlyForeachArrayVariable($node);
        if ($assignVariable === null) {
            return null;
        }
        if ($this->shouldSkipAsPartOfNestedForeach($node)) {
            return null;
        }
        $previousDeclaration = $this->nodeUsageFinder->findPreviousForeachNodeUsage($node, $assignVariable);
        if ($previousDeclaration === null) {
            return null;
        }
        $previousDeclarationParentNode = $previousDeclaration->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$previousDeclarationParentNode instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        // must be empty array, otherwise it will false override
        $defaultValue = $this->getValue($previousDeclarationParentNode->expr);
        if ($defaultValue !== []) {
            return null;
        }
        return new \PhpParser\Node\Expr\Assign($assignVariable, $node->expr);
    }
    private function shouldSkipAsPartOfNestedForeach(\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        $foreachParent = $this->betterNodeFinder->findFirstParentInstanceOf($foreach, \PhpParser\Node\Stmt\Foreach_::class);
        return $foreachParent !== null;
    }
}
